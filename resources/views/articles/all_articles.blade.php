@extends('layouts.app')
<style>
	.cardTextCustom{
		color: gray;
		font-size: 15px;
	}
</style>
@section('content')
		<div class="main_wrapper">
		<div class="intro_header">
			<div class="main_content">
				<div class="container">
					<div class="row">
						<div class="grid_section bloggers search_results text-center">
							<h2><span>Iceland Travel Blogs, Tips And Articles</span></h2>
							<p>Get Iceland travel tips from travellers and the locals</p>
							<div class="grid_content row">
								@foreach($all_articles as $article)
								<div class="col-sm-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
									<div class="card text-left">

										{{--<img class="card-img-top article-img-top" src="{{ url('public/images/0.jpg') }}" alt="Card image cap" style="height:100%;">--}}
										<img class="card-img-top article-img-top" src="{{ url('public/uploads/'.$article['single_photo']['photo']) }}" alt="Card image cap" style="height:100%;">
										{{--<img class="card-img-top" src="{{ asset('public/images/maxresdefault.jpg') }}" alt="Card image cap" style="height:60%;">--}}
										<div class="card-body">
											<div class="media-body">
												<style>
													@media screen and (max-width: 440px){
														#it{
															padding: 20px;
															font-size: 14px;
														}
														#its{
															padding: 20px;
															font-size: 14px;
														}
													}
												</style>
												<br>
												<div class="rateit float-right " id="it" style="padding: 10px;"></div>
												<h2  style="padding: 10px; font-size:20px;" id="its"><b>
												<a href="{{url('article/detail/'.$article['slug'])}}" style=" color:black" > {{$article['title']}}
												</a></b></h2>

												{{--<p>--}}
													{{--<img  src="{{ url('public/uploads/'.$article['single_photo']['photo']) }}">--}}
													{{--<span>0.5 mi to Sydney center</span>--}}
												{{--</p>--}}

												{{--Code for Keywords--}}
												{{--@if(!empty($article->keywords))--}}
												{{--<ul>--}}
														{{--@foreach($article->keywords as $key=> $keyword)--}}
													{{--<li class="text-capitalize">--}}
														{{--<strong>1</strong> --}}{{--{{$keyword->keyword_name}}--}}
													{{--</li>--}}
                                                        {{--@break($key==3)--}}
															{{--@continue($keyword==3)--}}
														{{--@endforeach--}}

													{{--<li>--}}
														{{--<strong>1</strong> BA</li>--}}
													{{--<li>--}}
														{{--<strong>538</strong> sq. ft.</li>--}}
													{{--<li>Sleeps--}}
														{{--<strong>6</strong>--}}
													{{--</li>--}}
												{{--</ul>--}}
												{{--@endif--}}
												{{--Code for Keywords--}}
												<div class="search_reviews">
													<!--<div class="float-right">
														<a href="{{url('article/detail/'.$article['slug'])}}" class="hvr-float-shadow view_all">View</a>
													</div>-->
													{{--<small class="text-success">Very Good! 4.2/5 </small>--}}
													{{--<h5>$137 per night</h5>--}}
													<div class="clearfix">
														{{--<a href="#" data-toggle="modal" data-target=".place_description">--}}
															{{--<span>View details for total price</span>--}}
														{{--</a>--}}
													</div>
													<p class="pt-3 card-text cardTextCustom">
														{!!$article['short_des']!!}
														{{--{!!substr($article['description'],100,100)!!}--}}
														<a class="card-title" href="{{url('article/detail/'.$article['slug'])}}" style="font-size: 12px;">
															read more...</a></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

@endsection