@foreach($post->position as $key => $position)
    <div class="marker_info">
        <input type="" class="lat_position" value="{{ $position->lat }}">
        <input type="" class="lng_position" value="{{ $position->lng }}">
        <input type="" class="marker_description" value="{{ $position->description }}">
        <input type="datetime-local" class="time_arrive" value="{{ $position->time_arrive ? date('Y-m-d\TH:i:s', strtotime($position->time_arrive)) : ''}}">
        <input type="datetime-local" class="time_leave" value="{{ $position->time_arrive ? date('Y-m-d\TH:i:s', strtotime($position->time_leave)) : ''}}">
    </div>
@endforeach
