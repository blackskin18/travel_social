<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 11/16/2018
 * Time: 9:00 PM
 */
namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Container\Container as App;

abstract class BaseRepository implements RepositoryInterface
{

    protected $app;

    protected $model;

    protected $fieldSearchable = array();

    protected $presenter;

    protected $validator;

    protected $rules = null;

    protected $criteria;

    protected $skipCriteria = false;

    protected $skipPresenter = false;

    protected $scopeQuery = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->criteria = new Collection();
        $this->makeModel();
        $this->makePresenter();
        $this->makeValidator();
        $this->boot();
    }

    public function boot()
    {

    }

    public function resetModel()
    {
        $this->makeModel();
    }

    abstract public function model();

    public function presenter()
    {
        return null;
    }

    public function validator()
    {

        if ( isset($this->rules) && ! is_null($this->rules) && is_array($this->rules) && !empty($this->rules) ) {
            if ( class_exists('Prettus\Validator\LaravelValidator') ) {
                $validator = app('Prettus\Validator\LaravelValidator');
                if ($validator instanceof ValidatorInterface) {
                    $validator->setRules($this->rules);
                    return $validator;
                }
            } else {
                throw new Exception( trans('repository::packages.prettus_laravel_validation_required') );
            }
        }

        return null;
    }

    public function setPresenter($presenter)
    {
        $this->makePresenter($presenter);
        return $this;
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function makePresenter($presenter = null)
    {
        $presenter = !is_null($presenter) ? $presenter : $this->presenter();

        if ( !is_null($presenter) ) {
            $this->presenter = is_string($presenter) ? $this->app->make($presenter) : $presenter;

            if (!$this->presenter instanceof PresenterInterface ) {
                throw new RepositoryException("Class {$presenter} must be an instance of Prettus\\Repository\\Contracts\\PresenterInterface");
            }

            return $this->presenter;
        }

        return null;
    }

    public function makeValidator($validator = null)
    {
        $validator = !is_null($validator) ? $validator : $this->validator();

        if ( !is_null($validator) ) {
            $this->validator = is_string($validator) ? $this->app->make($validator) : $validator;

            if (!$this->validator instanceof ValidatorInterface ) {
                throw new RepositoryException("Class {$validator} must be an instance of Prettus\\Validator\\Contracts\\ValidatorInterface");
            }

            return $this->validator;
        }

        return null;
    }

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function scopeQuery(\Closure $scope){
        $this->scopeQuery = $scope;
        return $this;
    }

    public function all($columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();

        if ( $this->model instanceof \Illuminate\Database\Eloquent\Builder ){
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        return $this->parserResult($results);
    }

    public function paginate($limit = null, $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->paginate($limit, $columns);
        $this->resetModel();
        return $this->parserResult($results);
    }

    public function find($id, $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    public function findByField($field, $value = null, $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field,'=',$value)->get($columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    public function findWhere( array $where , $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();

        foreach ($where as $field => $value) {
            if ( is_array($value) ) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field,$condition,$val);
            } else {
                $this->model = $this->model->where($field,'=',$value);
            }
        }

        $model = $this->model->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findWhereIn( $field, array $values, $columns = array('*'))
    {
        $this->applyCriteria();
        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    public function findWhereNotIn( $field, array $values, $columns = array('*'))
    {
        $this->applyCriteria();
        $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    public function create(array $attributes)
    {
        if ( !is_null($this->validator) ) {
            $this->validator->with($attributes)
                ->passesOrFail( ValidatorInterface::RULE_CREATE );
        }

        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id)
    {
        $this->applyScope();

        if ( !is_null($this->validator) ) {
            $this->validator->with($attributes)
                ->setId($id)
                ->passesOrFail( ValidatorInterface::RULE_UPDATE );
        }

        $_skipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($_skipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }

    public function delete($id)
    {
        $this->applyScope();

        $_skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);
        $originalModel = clone $model;

        $this->skipPresenter($_skipPresenter);
        $this->resetModel();

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);
        return $this;
    }

    public function visible(array $fields)
    {
        $this->model->setVisible($fields);
        return $this;
    }
}
