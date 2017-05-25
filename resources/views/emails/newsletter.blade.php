<div class="" style="margin:0;font-family: verdana,tahoma,arial,sans-serif;background-color: #f5f3f0;padding: 50px 0;">
	
	<div class="info-container" style="max-width: 700px;margin: auto; background-color: white;">
		
		<div class="header" style="padding: 20px 30px;text-align: center; background-color: #f5f3f0;">
			<a href="#" style="text-decoration: none;"><img style="width: 70px;" src="https://www.flexitech.io/img/flexi-logo.png" alt="flexitech logo"><h3 style="font-size: 18px;color: #41A291;margin: 8px 0 0 0;">FlexiTech IO News</h3></a>
		</div>

		<div class="top-news">
			@if ($news[0]->primaryMedia)
				<div class="photo">
					<img style="max-width: 100%;" src="{{ CMS::getNewsCover($news[0]) }}" alt="{{ $news[0]->title }}">
				</div>
			@endif
			<div class="info" style="padding: 10px 30px 20px 30px; border-bottom: 1px solid #F3F3F3;">
				<h5 style="margin: 15px 0;color: #888888;">Top Weekly News</h5>
				<h3 style="margin: 10px 0;color: #41A291;">{{ $news[0]->title }}</h3>
				<p style="margin: 0;">
					​{{ strip_tags(substr($news[0]->description, 0, 160)) }}...
				</p>
			</div>
		</div>
		<div class="other-news" style="padding: 10px 30px;">
			@if (count($news) > 1)
				<h5 style="margin: 10px 0;color: #888888;">More Headlines</h5>
				<ul style="list-style-type: none;padding: 0;">
					@for($i = 1; $i < count($news); $i++)
						<li style="margin-bottom: 8px;"><a href="{{ URL::to('/'.CMS::slugify($news[$i])) }}" style="color: #43A998;text-decoration: none;font-size: 16px;font-weight: bold;">{{ $news[$i]->title }}</a></li>
					@endfor
				</ul>
			@endif

			<div style="text-align: center; padding: 30px 0;">
				<a href="https://www.flexitech.io/news" style="text-decoration: none;display: inline-block;padding: 15px 20px;color: white;font-size: 16px; background-color: #41A291; border: none;border-radius:6px;">More stories on FlexiTech News</a>
			</div>

		</div>

		<div class="promote">
			
		</div>

		<div class="footer" style="padding: 30px 0; background-color: #41A291;">
			<ul style="list-style-type: none;padding: 0; text-align: center;margin-top: 5px;">
				<li style="display: inline-block;"><a href="#" style="padding: 0 5px;"><img style="width: 25px;" src="{{ URL::asset('/img/fb-icon.gif') }}" alt="flexitech facebook page"></a></li>
				<li style="display: inline-block;"><a href="#" style="padding: 0 5px;"><img style="width: 25px;" src="{{ URL::asset('/img/tw-icon.gif') }}" alt="flexitech facebook page"></a></li>
				<li style="display: inline-block;"><a href="#" style="padding: 0 5px;"><img style="width: 25px;" src="{{ URL::asset('/img/gplus-icon.gif') }}" alt="flexitech facebook page"></a></li>
			</ul>
			<div style="padding-top: 0px;text-align: center; color: white; font-size: 14px;">
				©{{ date("Y") }} <a href="{{ URL::to('/news') }}" style="color: white; text-decoration: none; position: relative;">FlexiTech IO<hr style="width: 100%;margin: 0;position: absolute;left: 0;bottom: -2px; height:0 ;border: 1px dashed rgba(255,255,255,.2);"></a>. All Rights Reserved
			</div>
		</div>

	</div>


	<div class="unsubcribe" style="text-align: center; padding: 30px 0;">
		<a href="{{ $unsubscribeLink }}" style="color: #41A291;">Unsubscribe</a>
	</div>

</div>

