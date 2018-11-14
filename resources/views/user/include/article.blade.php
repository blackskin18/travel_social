			<section id="two">
				<div class="row">
					<article class="col-2 col-12-xsmall" style="padding: 0 0 0 2.5em">
						<img style="border-radius: 50%; width:75px; height: 75px " src="{{ url('asset/images/avatar/'.$user->id.'/'.$user->avatar) }}" alt="">
					</article>
					<article class="col-10 col-12-xsmall" style="padding: 0">
						<h2 class="none-padding none-margin">
							<a href="" style="color: #5cc6a7; text-decoration: none">
								{{ $user->name }}
							</a>
							đã đăng bài viết
						</h2>
						<p>
							31 Tháng 10 lúc 20:54
						</p>
					</article>
				</div>
				<div class="">
					Allowable values self-explanatory:  none (disables textarea resizing), both, vertical and horizontal.  The default in Firefox, Safari, and Chrome is both.

					If you want to constrain the width and height of the textarea element, that's not a problem:  these browsers also respect max-height, max-width, min-height, and min-width CSS properties to provide resizing within certain proportions:
				</div>
				<div class="row">
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/01.jpg" class="image fit"><img src="{{ url('asset/images/image_article/01.jpg') }}" alt="" /></a>
					</article>
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/02.jpg" class="image fit"><img src="{{ url('asset/images/image_article/02.jpg') }}" alt="" /></a>
					</article>
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/03.jpg" class="image fit"><img src="{{ url('asset/images/image_article/03.jpg') }}" alt="" /></a>
					</article>
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/04.jpg" class="image fit"><img src="{{ url('asset/images/image_article/04.jpg') }}" alt="" /></a>
					</article>
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/05.jpg" class="image fit"><img src="{{ url('asset/images/image_article/05.jpg') }}" alt="" /></a>
					</article>
					<article class="col-4 col-12-xsmall work-item">
						<a href="images/fulls/06.jpg" class="image fit thumb" style="content:'11111'"><img src="{{ url('asset/images/image_article/06.jpg') }}" alt="" /></a>
					</article>
				</div>
				<ul class="actions">
					<li><a href="#" class="button">Full Portfolio</a></li>
				</ul>
			</section>
