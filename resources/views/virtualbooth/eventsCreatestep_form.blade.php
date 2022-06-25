
	
	   <div id="nb_mm">
		      <!-- Unique Id Begin -->
	   <ul class='screens-menu'> 
			<span class="menu-header">Add As:</span>

			<li data-action = "frames" data-type="frames" data-needsedit="no" class="imagetypes frames-menu">Photo Frame</li>
			<li data-action = "start" data-type="splash" data-needsedit="no" class="imagetypes">Start Screen</li>
			<li data-action = "thanks" data-type="thanks" data-needsedit="no"  class="imagetypes">Thanks Screen</li>
			<!--<li data-action = "both" data-type="both" data-needsedit="no">Start & Thanks Screens</li>-->
			<li data-action = "backgrounds" data-type="backgrounds" data-needsedit="no" class="imagetypes backgrounds-menu">Background </li>		
		</ul> 
			<div class="container">
			<!-- Sidebar Begin -->
			
				<div class="row">
					<div class="sidebar-wpr">
						<div class="iconbar">
						  
							
							<div class="sideslider" style="transform: translateY(75px); height: 56px;"></div>
							<div class="nav flex-column nav-pills lib-categories" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								
								<ul class="nav  flex-column nav-pills" id="v-pills-tab role="tablist">
																	
									<li class="text-center nav-item">
										<button class="nav-link active" href="#v-pills-frames"  id="frames-btn" data-toggle="pill">
											<div class="button-wrapper" onClick="openNav('left',1)">
												<i class="far fa-object-group" ></i>
												<div style="margin-top:-5px;">
													<span class="iconbar-label">Frames</span>
												</div>
											</div>
										</button>
									</li>
									<li class="text-center nav-item" >
										<button class="nav-link" href="#v-pills-backgrounds"  id="backgrounds-btn" data-toggle="pill">
											<div class="button-wrapper" onClick="openNav('left',2)">
												<i class="fas fa-image" ></i>
												<div style="margin-top:-5px;">
													<span class="iconbar-label">Photos</span>
												</div>
											</div>
										</button>
									</li>
									<li class="text-center nav-item" >
										<button class="nav-link" href="#v-pills-stickers"  id="stickers-btn" data-toggle="pill">
											<div class="button-wrapper" onClick="openNav('left',3)">
												<i class="far fa-smile" ></i>
												<div style="margin-top:-5px;">
													<span class="iconbar-label">Stickers</span>
												</div>
											</div>
										</button>
									</li>
									<li class="text-center nav-item" >
										<button class="nav-link" href="#v-pills-gifs"  id="gifs-btn" data-toggle="pill">
											<div class="button-wrapper" onClick="openNav('left',4)">
												<i class="fas fa-film" ></i> 
												<div style="margin-top:-5px;">
													<span class="iconbar-label">GIFs</span>
												</div>
											</div>
										</button>
									</li>
									
									
								</ul>
							</div>

						</div>
						<div id="LeftSideNav" class="sidenav" scrollbar>
						
							<div class="tab-content" id="v-pills-tabContent" >  
						   
							
								<div class="tab-pane fade show active"  id="v-pills-frames" role="tabpanel" aria-labelledby="v-pills-frames-tab">
									<div class="lib-container">
										<div class="head">Frames</div>
											<span id="frames-holder">
												@php
												$photobooth = \App\Photobooth::where('type','frame')->get();


												@endphp
												<div id="splide">
  <div class="splide__progress">
    <div class="splide__progress__bar"></div>
  </div> <!-- /.splide__progress -->
  
  
	<div class="splide__track" id="splide-track">
		<ul class="splide__listss">
			<div id="imgae_coll"></div>
			


												@foreach($photobooth as $key => $photo)
												@php $b_img = "storage/photobooth/$photo->template"; @endphp


			<li class="splide__slide">

			<div class="imageframe lib-item splide__slide__container" data-id="type{{ $photo->id }}" data-img="{{ $photo->template }}" data-src="{{ asset($b_img) }}" data-type="frames" style="height: 80px; background: url({{ asset($b_img) }}) center center / cover no-repeat;">
			<img class="imageframe" src="{{ asset($b_img) }}" style="width:80px; height:80px;display:none;">
		</div>
      </li>
  
      
	
												@endforeach
												</ul> <!-- /.splide__list -->
	</div> <!-- /.splide__track -->
</div> <!-- /.splide -->
											</span>
									</div><div class="closebtn" style="">
						<a href="javascript:void(0)" onclick="closeNav('left')"><svg viewBox="0 0 32 112" xmlns="http://www.w3.org/2000/svg"><path d="M22.626 17.865l-1.94-1.131C17.684 14.981 16 12.608 16 10.133V0H0v112h16v-10.135c0-2.475 1.684-4.849 4.686-6.6l1.94-1.131C28.628 90.632 32 85.885 32 80.934v-49.87c0-4.95-3.372-9.698-9.374-13.199" fill="#293039"></path></svg><span aria-hidden="true" class="closex"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.25" d="M7 3.17L4.88 5.3a1 1 0 0 0 0 1.42L7 8.83"></path></svg></span></a>
						</div>
								</div>
								 
								<div class="tab-pane  fade " id="v-pills-stickers" role="tabpanel" aria-labelledby="v-pills-stickers-tab">
									<div class="lib-container">
										<div class="row">
											<div class="col-sm-10">
												<div class="head">Stickers</div>
											</div>
											<a href="#" onClick='$("#assetNav").css("z-index","9999")'><div id="closeStickers"  class="col-sm-1" style="margin-top: 10px;display:none;">
												<mat-icon _ngcontent-sbr-c74="" role="img" class="mat-icon notranslate mat-icon-no-color" aria-hidden="true" data-mat-icon-type="svg" data-mat-icon-name="close"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false" style="color: #FFF;"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg></mat-icon>
											</div></a>
										</div>
											<div class="search-wrapper">
												<form class="js-formStickers" style="height:50px;">
													<svg class="searchIcon" viewBox="0 0 16 16" width="16" height="16"><path d="M12.331 11.0694L15.8859 14.6286C16.0447 14.8052 16.0368 15.0755 15.8681 15.2425L15.246 15.8654C15.1626 15.9496 15.049 15.997 14.9305 15.997C14.812 15.997 14.6985 15.9496 14.615 15.8654L11.0601 12.3062C10.9618 12.2077 10.8726 12.1005 10.7935 11.9859L10.127 11.0961C9.02413 11.9778 7.6546 12.4579 6.24327 12.4575C3.33502 12.4676 0.807867 10.459 0.157951 7.62088C-0.491966 4.78275 0.90881 1.87252 3.53098 0.613141C6.15315 -0.646241 9.29689 0.0813292 11.101 2.36511C12.9052 4.64889 12.8882 7.87938 11.0601 10.144L11.9489 10.758C12.0877 10.8469 12.2159 10.9514 12.331 11.0694ZM1.79957 6.22901C1.79957 8.68611 3.78905 10.678 6.24318 10.678C7.4217 10.678 8.55195 10.2092 9.38529 9.37491C10.2186 8.54056 10.6868 7.40895 10.6868 6.22901C10.6868 3.77192 8.69732 1.78005 6.24318 1.78005C3.78905 1.78005 1.79957 3.77192 1.79957 6.22901Z"></path></svg>
													<input type="text" class="search-input js-search-inputStickers" placeholder="Search stickers" autofocus>
													<button type="submit" class="btn" style="position:absolute;right:0px;">Go</button>
												</form>
												<div class="splide">
													
													<!-- <div class="splide__track" data-num="">
														<ul class="splide__list cats">
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="curated" data-type="cat2" data-name="Curated">
																	Curated
																</button>
															</li>
															
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="love" data-type="cat2" data-name="Love">
																	Love
																</button> 
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="heart" data-type="cat2" data-name="Heart">
																	Heart
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="birthday" data-type="cat2" data-name="Birthday">
																	Birthday
																</button>
															</li>
															
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="frame" data-type="cat2" data-name="Frame">
																	Frame
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="border" data-type="cat2" data-name="Border">
																	Border
																</button>
															</li>
															<li class="splide__slide"> 
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="food" data-type="cat2" data-name="Food">
																	Food
																</button>
															</li>
															
															
														</ul>
													</div> -->
												</div>
											</div>
											<span id="stickers-holder" class="asplide__listssetrtrets">
											@php
												$photoboothsticker = \App\Photobooth::where('type','sticker')->get();
                                                        @endphp
														<ul class="splide__listsss">
			<div id="imgae_collss"></div>
												@foreach($photoboothsticker as $key => $photo)
												@php $b_img = "storage/photobooth/$photo->template"; @endphp



												<li class="splide__slide">

<div class="imagesticker lib-item splide__slide__containers"  data-id="type{{ $photo->id }}" data-img="{{ $photo->template }}" data-src="{{ asset($b_img) }}" data-type="frames" style="height: 80px; background: url({{ asset($b_img) }}) center center / cover no-repeat;">
<img class="imageframesss" src="{{ asset($b_img) }}" style="width:80px; height:80px;display:none;">
</div>
</li>
		@endforeach
		</ul> <!-- /.splide__list -->										
											</span> 
											
											<div class="paginationStickers">
												<button class="hidden prev-btn js-prevStickers" style="display:none;"><a href="#top" style="display:none;">Previous page</a></button>
												<div class="text-center">
													<button class="next-btn js-nextStickers c-btn c-btn--info"  style="display:none;">Load More</button>
												</div>
											</div>
									</div>
								</div>
								
								<div class="tab-pane  fade " id="v-pills-gifs" role="tabpanel" aria-labelledby="v-pills-gifs-tab">
									<div class="lib-container">
										<div class="head">Gifs</div>
										
											<div class="search-wrapper">
												<form class="js-formGifs" style="height:50px;">
													<svg class="searchIcon" viewBox="0 0 16 16" width="16" height="16"><path d="M12.331 11.0694L15.8859 14.6286C16.0447 14.8052 16.0368 15.0755 15.8681 15.2425L15.246 15.8654C15.1626 15.9496 15.049 15.997 14.9305 15.997C14.812 15.997 14.6985 15.9496 14.615 15.8654L11.0601 12.3062C10.9618 12.2077 10.8726 12.1005 10.7935 11.9859L10.127 11.0961C9.02413 11.9778 7.6546 12.4579 6.24327 12.4575C3.33502 12.4676 0.807867 10.459 0.157951 7.62088C-0.491966 4.78275 0.90881 1.87252 3.53098 0.613141C6.15315 -0.646241 9.29689 0.0813292 11.101 2.36511C12.9052 4.64889 12.8882 7.87938 11.0601 10.144L11.9489 10.758C12.0877 10.8469 12.2159 10.9514 12.331 11.0694ZM1.79957 6.22901C1.79957 8.68611 3.78905 10.678 6.24318 10.678C7.4217 10.678 8.55195 10.2092 9.38529 9.37491C10.2186 8.54056 10.6868 7.40895 10.6868 6.22901C10.6868 3.77192 8.69732 1.78005 6.24318 1.78005C3.78905 1.78005 1.79957 3.77192 1.79957 6.22901Z"></path></svg>
													<input type="text" class="search-input js-search-inputGifs" placeholder="Search GIFs" value="Start"autofocus> 
													<button type="submit" id="gifSearch" class="btn" style="position:absolute;right:0px;">Go</button>
												</form> 
												<div class="splide">
													<div class="splide__track" data-num="">
														<ul class="splide__list cats">
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="start" data-type="cat3" data-name="Start">
																	Start
																</button> 
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="thanks" data-type="cat3" data-name="Thanks">
																	Thanks
																</button> 
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="party" data-type="cat3" data-name="Party">
																	Party
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="selfie" data-type="cat3" data-name="ai">
																	Selfie
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="love" data-type="cat3" data-name="Love">
																	Love
																</button> 
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="birthday" data-type="cat3" data-name="Birthday">
																	Birthday
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="wedding" data-type="cat3" data-name="Wedding">
																	Wedding
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="christmas" data-type="cat3" data-name="Christmas">
																	Christmas
																</button> 
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="halloween" data-type="cat3" data-name="Halloween">
																	Halloween
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="virtual" data-type="cat3" data-name="Virtual">
																	Virtual
																</button>
															</li>
															
														</ul>
													</div>
												</div>
											</div>
											<span id="gifs-holder">
																						
											</span> 
											
											<div class="paginationGifs">
												<button class="hidden prev-btn js-prevGifs" style="display:none;"><a href="#top" style="display:none;">Previous page</a></button>
												<div class="text-center">
													<button class="next-btn js-nextGifs c-btn c-btn--info"  style="display:none;">Load More</button>
												</div>
											</div>
									</div>
								</div> 
								
								<div class="tab-pane  fade " id="v-pills-backgrounds" role="tabpanel" aria-labelledby="v-pills-backgrounds-tab">
									<div class="lib-container">
										<div class="head">Photos</div>
											<div class="search-wrapper">
												<form class="js-form" style="height:50px;">
													<svg class="searchIcon" viewBox="0 0 16 16" width="16" height="16"><path d="M12.331 11.0694L15.8859 14.6286C16.0447 14.8052 16.0368 15.0755 15.8681 15.2425L15.246 15.8654C15.1626 15.9496 15.049 15.997 14.9305 15.997C14.812 15.997 14.6985 15.9496 14.615 15.8654L11.0601 12.3062C10.9618 12.2077 10.8726 12.1005 10.7935 11.9859L10.127 11.0961C9.02413 11.9778 7.6546 12.4579 6.24327 12.4575C3.33502 12.4676 0.807867 10.459 0.157951 7.62088C-0.491966 4.78275 0.90881 1.87252 3.53098 0.613141C6.15315 -0.646241 9.29689 0.0813292 11.101 2.36511C12.9052 4.64889 12.8882 7.87938 11.0601 10.144L11.9489 10.758C12.0877 10.8469 12.2159 10.9514 12.331 11.0694ZM1.79957 6.22901C1.79957 8.68611 3.78905 10.678 6.24318 10.678C7.4217 10.678 8.55195 10.2092 9.38529 9.37491C10.2186 8.54056 10.6868 7.40895 10.6868 6.22901C10.6868 3.77192 8.69732 1.78005 6.24318 1.78005C3.78905 1.78005 1.79957 3.77192 1.79957 6.22901Z"></path></svg>
													<input type="text" class="search-input js-search-input" placeholder="Search photos" autofocus>
													<button type="submit" class="btn" style="position:absolute;right:0px;">Go</button>
												</form>
												<div class="splidess">
												@php
												$photoboothimage = \App\Photobooth::where('type','photo')->get();


												@endphp
												@foreach($photoboothimage as $key => $photo)
												@php $b_img = "storage/photobooth/$photo->template"; @endphp


			<div class="imageframe lib-item splide__slide__container" data-img="{{ $photo->template }}" data-src="{{ asset($b_img) }}" data-type="frames" style="height: 80px; background: url({{ asset($b_img) }}) center center / cover no-repeat;">
			<img class="imageframe" src="{{ asset($b_img) }}" style="width:80px; height:80px;display:none;">
		</div>
   
  
      
	
												@endforeach
													<!-- <div class="splide__track" data-num="">
														<ul class="splide__list cats">
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="curated" data-type="cat" data-name="Curated">
																	Curated
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="background" data-type="cat" data-name="Background">
																	Background
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="pattern" data-type="cat" data-name="Pattern">
																	Pattern
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="texture" data-type="cat" data-name="Texture">
																	Texture
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="party" data-type="cat" data-name="Party">
																	Party
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="birthday" data-type="cat" data-name="Birthday">
																	Birthday
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="wedding" data-type="cat" data-name="Wedding">
																	Wedding
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="blur" data-type="cat" data-name="Blur">
																	Blur
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="neon" data-type="cat" data-name="Neon">
																	Neon
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="minimal" data-type="cat" data-name="Minimal">
																	Minimal
																</button>
															</li>
															<li class="splide__slide">
																<button type="button" class="lib-item splide__slide__container btn btn-dark" data-src="holidays" data-type="cat" data-name="Holidays">
																	Holidays
																</button>
															</li>
														</ul>
													</div> -->
												</div>
											</div>
											<span id="backgrounds-holder">
												<div class=""><div class="" data-num=""><ul class="background-list" style="padding-left:2px;width:325px;display:flex;flex-wrap: wrap;">
											</ul></div></div>
											
											</span> 
											<div class="paginations">
												<button class="hidden prev-btn js-prev" style="display:none;"><a href="#top" style="display:none;">Previous page</a></button>
												<div class="text-center">
													<button class="next-btn js-next c-btn c-btn--info" style="display:none;">Load More</button>
												</div>
											</div>
									</div>
								</div>
								
							</div>
						</div>
						<div class="closebtn">
						<a href="javascript:void(0)"  onClick="closeNav('left')"><svg viewBox="0 0 32 112" xmlns="http://www.w3.org/2000/svg"><path d="M22.626 17.865l-1.94-1.131C17.684 14.981 16 12.608 16 10.133V0H0v112h16v-10.135c0-2.475 1.684-4.849 4.686-6.6l1.94-1.131C28.628 90.632 32 85.885 32 80.934v-49.87c0-4.95-3.372-9.698-9.374-13.199" fill="#293039"></path></svg><span aria-hidden="true" class="closex"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.25" d="M7 3.17L4.88 5.3a1 1 0 0 0 0 1.42L7 8.83"></path></svg></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Unique Id End -->
<div class="container">
						<div class="row mt-3">
						  <div class="process">
						   <div class="process-row nav nav-tabs nav-justified">
							<a data-toggle="tab" href="#standard" id="standard-tab" role="tab" class="not-design-tab active" aria-selected="true"><div class="process-step ml-5">
							 <button type="button" id="btn-standard" class="btn btn-nav btn-circle btn-primary"><i class="fa fa-info fa-3x"></i></button>
							 <p><small>General</small></p>
							</div></a>
							
							<a data-toggle="tab" href="#styles" id="styles-tab" role="tab" class="design-tab" aria-selected="false">
							<div class="process-step pl-4">
							 <button type="button" class="btn btn-nav btn-circle btn-default"><i class="fa fa-paint-brush fa-3x"></i></button>
							 <p><small>Design</small></p>
							</div></a>
							<a data-toggle="tab" href="#text" class="not-design-tab"><div class="process-step pl-4">
							 <button type="button" class="btn btn-nav btn-circle btn-default"><i class="fa fa-align-justify fa-3x"></i></button>
							 <p><small>Text</small></p>
							</div></a>
							<a data-toggle="tab" href="#sharing" class="not-design-tab">
							<div class="process-step pl-4">
							 <button type="button" class="btn btn-nav btn-default btn-circle"><i class="fas fa-share-square fa-3x"></i></button>
							 <p><small>Sharing</small></p>
							</div></a>
							<!--<a data-toggle="tab" href="#surveys">
							<div class="process-step">
							 <button type="button" class="btn btn-nav btn-default btn-circle" ><i class="fas fa-edit fa-3x"></i></button>
							 <p><small>Surveys</small></p>
							</div></a>-->
							<a data-toggle="tab" href="#whitelabel" class="not-design-tab">
							<div class="process-step pl-4">
							 <button type="button" class="btn btn-nav btn-circle active btn-default" data-toggle="tab" href="#whitelabel"><i class="fas fa-user-secret fa-3x"></i></button> 
							 <p><small>White Label</small></p>
							</div></a>
						   </div>
						  </div>
						</div>
					</div>

                    <form action="#"  class="" id="newEventForm">
							<div class="tab-content">
								<!--Standard Start-->
								<div class="tab-pane fade show active" id="standard">
									<div id="form-name" class="form-group row">
										<label for="name" class="col-sm-3 col-form-label">Event Name</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="event-name" value="My Event" name="event_name" required>
										</div>
										
									</div>
									
																	
									<div id="form-type" class="form-group row" >
									
										<label for="photoType" class="col-sm-3 col-form-label">Size</label>
										<div class="col-sm-9" style="margin-left:-20px;">
											<div class="radio-tile-group">
												<div class="col-sm-3 size">
													<div class="container">
														<div class="row">
															<div class="input-container">
																<input id="photoType1" class="radio-button"  type="radio" name="photoType" value="square"/>
																<div class="radio-tile">
																	
																	<div class="form-group row pt-2">
																		<div class="col-1 pl-1">
																			<span class="tick-wrapper">
																				<span class="tick"><i class="fas fa-check-square"></i></span>
																			</span>
																		</div>
																		<div class="col-1 dropdown tools-item dropright"></div>
																	</div>
																	<div class="row ">
																		<div class="icon" >
																		  <i class="fas fa-user"></i>
																		</div> 
																	</div>
																	<div class="row">
																		<p><small>Square</small></p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-3 size">
													<div class="container">
														<div class="row">
															<div class="input-container radio-rect">
																<input id="photoType2" class="radio-button" type="radio" name="photoType" value="portrait"/>
																<div class="radio-tile">
																	
																	<div class="form-group pt-2">
																		<div class="col-1 pl-1">
																			<span class="tick-wrapper">
																				<span class="tick"><i class="fas fa-check-square"></i></span>
																			</span>
																		</div>
																		
																	</div>
																	<div class="row">
																		<div class="icon" >
																		  <i class="fas fa-user"></i>
																		</div> 
																	</div>
																	<div class="row">
																		<p><small>Portrait</small></p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>	
										</div>
									</div>
									
									
									
									<!--Experiences Start-->
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label">Experiences</label>
										
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="experiencePhoto" name="experiencePhoto" value="1"> 
												<label for="experiencePhoto">Off</label> 
											</div>									
										</div>								
										<div class="col-sm-1 pl-2 limit-sm">Photo</div>
										
																				<div class="col-sm-1 ml-4 mt-2 limit-sm3">
											<div class="switchToggle">
												<input type="checkbox" id="experienceGif" name="experienceGif" value="1"> 
												<label for="experienceGif">Off</label> 
											</div>
											
										</div>
																				
										<div class="col-sm-1 mr-2 pl-2 limit-sm">GIF <a href="#" id="gifSettingsButton"><i class="fas fa-cog ml-2" style="font-size:16px;top:3px;position:absolute;"></i></a>
										<ul id='gifSettingsMenu' style="display:none;"> 
											<span class="menu-header">Speed:</span>
											<li>
												<div class="custom-control2 custom-radio">
													<input type="radio" id="gifSpeed1" name="gifSpeed" class="custom-control-input2 gifspeed" value="slow">
													<label class="custom-control-label" for="gifSpeed1" style="cursor:pointer;">Slow</label>
												</div>
											</li>
											<li>			
												<div class="custom-control2 custom-radio">
													<input type="radio" id="gifSpeed2" name="gifSpeed" class="custom-control-input2 gifspeed" value="medium" checked>
													<label class="custom-control-label" for="gifSpeed2" style="cursor:pointer;">Medium</label>
												</div>
											</li>
											<li>
												<div class="custom-control2 custom-radio">
													<input type="radio" id="gifSpeed3" name="gifSpeed" class="custom-control-input2 gifspeed" value="fast">
													<label class="custom-control-label" for="gifSpeed3" style="cursor:pointer;">Fast</label>
												</div>
											</li>
										</ul>
										</div>				
																				<div class="col-sm-1 ml-0 mt-2  limit-sm2">
											<div class="switchToggle">
												<input type="checkbox" id="experienceBoomerang" name="experienceBoomerang" value="1"> 
												<label for="experienceBoomerang">Off</label> 
											</div>
										</div>
																				<div class="col-sm-3 pl-2 limit-sm">Boomerang <a href="#" id="boomerangSettingsButton"><i class="fas fa-cog ml-2" style="font-size:16px;top:3px;position:absolute;"></i></a>
										<ul id='boomerangSettingsMenu' style="display:none;"> 
											<span class="menu-header">Speed:</span>
											<li>
												<div class="custom-control2 custom-radio">
													<input type="radio" id="boomerangSpeed1" name="boomerangSpeed" class="custom-control-input2 boomerangspeed" value="slow">
													<label class="custom-control-label" for="boomerangSpeed1" style="cursor:pointer;">Slow</label>
												</div>
											</li>
											<li>			
												<div class="custom-control2 custom-radio">
													<input type="radio" id="boomerangSpeed2" name="boomerangSpeed" class="custom-control-input2 boomerangspeed" value="medium" checked>
													<label class="custom-control-label" for="boomerangSpeed2" style="cursor:pointer;">Medium</label>
												</div>
											</li>
											<li>
												<div class="custom-control2 custom-radio">
													<input type="radio" id="boomerangSpeed3" name="boomerangSpeed" class="custom-control-input2 boomerangspeed" value="fast">
													<label class="custom-control-label" for="boomerangSpeed3" style="cursor:pointer;">Fast</label>
												</div>
											</li>
										</ul>
										</div>
										
									</div>
																		<div class="col-lg-12 mx-auto mb-4">
										<div class="accordion" id="accordionExampleE">
											
												<div class="card" style="border:1px solid rgba(0, 0, 0, 0.125)!important;">
													<div class="card-header" id="headingOneE">
														<h2 class="clearfix mb-0">
															<a class="btn btn-link" data-toggle="collapse" id="accordian-frames" data-target="#collapse-frames" aria-expanded="true" aria-controls="collapse-frames">	Frames <i class="fas fa-question-circle ml-1" style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="<div class='text-justify'><b>Format</b>: .png<br><b>Size-Square</b>: 1600x1600 <br><b>Size-Portrait</b>: 1200x1800<br><b>DPI</b>: 72</div>"></i></a><i class="fas fa-chevron-right float-right"></i>				
														</h2>
													</div>
													<div id="collapse-frames" class="collapse show" aria-labelledby="headingOneE" data-parent="#accordionExampleE">
														<div class="card-body">
															<div id="form-images" class="form-group row ">
																<div class="col-sm-12 d-flex justify-content-center">
																	<div class="row justify-content-center"> 	
																		<div class="dropzone" id="dz-frames">									
																			<div class="dz-message needsclick">
																			
																				<button type="button" class="dz-button">Choose 1 or more images.</button><br>
																				<span class="note needsclick dimDisplay photo">1600px x 1600px</span>
																		  </div>

																		  
																		</div>
																	</div>
																</div>
															</div>
															<input class="templimg" id="templ_img" type="hidden" />
															<input class="templimg" id="templ_img2" type="hidden" />
															<input class="templimg" id="templ_img3" type="hidden" />

															<input name="frames" class="fileField" id="frames" type="hidden" />
															<div id="form-type" class="form-group row  d-flex align-items-center">
																<label class="col-sm-4 col-form-label" style="padding-right:0;">Add User Input to Frame<a href="#" data-tooltip="tooltip" data-placement="top" title="Ask the user for input, like their name to be added to the photo. Be sure to edit the frames to add placeholder text."><i class="fas fa-question-circle ml-1" ></i></a></label>
																 
																<div class="col-sm-1 mt-2 limit-sm ">
																	<div class="switchToggle">
																		<input type="checkbox" id="enableUserInput" name="enableUserInput" value="1"> 
																		<label for="enableUserInput">Off</label>  
																	</div>									
																</div>
																																<div class="col-sm-2 pl-5 mr-0 pr-0">
																Prompt 
																</div>
																<div class="col-sm-5 pl-0">
																<input type="text" class="form-control" id="userInputText" value="Enter your name" value="Enter your name" name="userInputText" >
																</div>
								
																
															</div>
														</div>
														
													</div>
												</div> 
												
											
										</div>
										
									</div>
																		
									
									<!--Experiences End-->
									
									<!--Options Start-->
									<div id="form-type" class="form-group row d-flex align-items-center">
										<label class="col-sm-3 col-form-label">Photo Options</label>
																				<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="optionsFilters" name="optionsFilters" value="1"> 
												<label for="optionsFilters">Off</label> 
											</div>
											
										</div>
																				<div class="col-sm-1 pl-2 limit-sm">Filters</div>
										
																				<div class="col-sm-1 ml-4 mt-2 limit-sm4">
											<div class="switchToggle">
												<input type="checkbox" id="optionsStickers" name="optionsStickers" value="1"> 
												<label for="optionsStickers">Off</label> 
											</div>
											
										</div>
																				<div class="col-sm-1 mr-2 pl-2 limit-sm">Stickers</div>
																				<div class="col-sm-1 ml-0 mt-2 limit-sm3">
											<div class="switchToggle">
												<input type="checkbox" id="optionsBg" name="optionsBg" value="1"> 
												<label for="optionsBg">Off</label> 
											</div>
											
										</div>
																				<div class="col-sm-3 pl-2 pr-0 limit-sm5">Background Removal <a href="#" data-tooltip="tooltip" data-placement="top" title="Remove the background from the photo without green screen."><i class="fas fa-question-circle ml-1" ></i></a></div>
									</div>	
																		<div class="col-lg-12 mx-auto mb-4">
										<div class="accordion" id="accordionExample">
											<div class="card">
												<div class="card-header" id="headingOne">
													<div class="row">
													
												<div class="col-sm-12">
													<h2 class="clearfix mb-0">
														<a class="btn btn-link collapsed" id="accordian-stickers" data-toggle="collapse" data-target="#collapse-stickers" aria-expanded="false" aria-controls="collapse-stickers">Stickers</a><i class="fas fa-chevron-right float-right"></i>				
													</h2>
												</div>
													</div>
												</div>
												<div id="collapse-stickers" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
													<div class="card-body">
														<div id="form-images" class="form-group row ">
									
															<div class="col-sm-12 d-flex justify-content-center">
																<div class="row justify-content-center"> 
																	<div class="dropzone" id="dz-stickers">									
																		<div class="dz-message needsclick">
																		
																			<button type="button" class="dz-button">Choose 1 or more files.</button><br>
																			<span class="note needsclick dimDisplay stickers"></span>
																	  </div>
																	</div>
																</div>
															</div>
														</div>
														<input name="stickers" class="fileField" id="stickers" type="hidden" />
														<div class="alert alert-primary small" role="alert">Stickers should be transparent pngs no more than 300px in any dimension. </div>	
													</div>
													
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingTwo">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed align-items-start" id="accordian-backgrounds" data-toggle="collapse" data-target="#collapse-backgrounds" aria-expanded="false" aria-controls="collapse-backgrounds" style="width:600px;">Background Removal</a><i class="fas fa-chevron-right float-right"></i>
													</h2>
												</div>
												<div id="collapse-backgrounds" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
													<div class="card-body">
														
														<div class="row mb-2 d-flex align-items-center">
															<label for="credits" class="col-sm-3 ml-3 pl-0 col-form-label">Credits Remaining</label>
																<div class="col-sm-1 pl-0 pr-0 ml-0 mr-0">
																
																
																5																
															</div>
															<div class="col-sm-3 m-0 p-0">
																<button type="button" class="btn btn-success btn-sm mb-1" id="buymore">
																	<span class="btn-label"><i class="fas fa-shopping-cart"></i></span>
																	Buy More Credits
																</button>
															</div>
															<div class="col-sm-4 m-0 p-0">
																<small>
																1 background removal uses 1 credit.
																</small>
															</div>
														</div>
														
														<div id="form-images" class="form-group row ">
															
															<div class="col-sm-12 d-flex justify-content-center">
																<div class="row justify-content-center"> 
																	<div class="dropzone" id="dz-backgrounds">									
																		<div class="dz-message needsclick">
																			<button type="button" class="dz-button">Choose 1 or more files.</button><br>
																			<span class="note needsclick dimDisplay photo">1600px x 1600px</span>
																		</div>
																  </div>
																</div>
															</div>
														</div>
														<input name="backgrounds" class="fileField" id="backgrounds" type="hidden" />
														
														<div id="form-type" class="form-group row  d-flex align-items-center">
																<label class="col-sm-4 col-form-label" style="padding-right:0;">Auto Apply Background<a href="#" data-tooltip="tooltip" data-placement="top" title="Automatically apply the first background."><i class="fas fa-question-circle ml-1" ></i></a></label>
																<div class="col-sm-1 mt-2 limit-sm ">
																	<div class="switchToggle">
																		<input type="checkbox" id="autoBG" name="autoBG" value="1"> 
																		<label for="autoBG">Off</label>  
																	</div>									
																</div>
																
								
																
														</div>

														
													</div>
												</div>
											</div>
											
										</div>
									</div>	
																		<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label" >Session Options</label>
										 <div class="col-sm-4 mt-2">
											<div class="form-group row d-flex align-items-center">
												<div class="col-sm-3 mt-2">
													<div class="switchToggle">
														<input type="checkbox" id="flipImage" name="flipImage" value="1"> 
														<label for="flipImage">Off</label> 
													</div>
												</div>
												<div class="col-sm-9 ">Flip Selfie Photo <a href="#" data-tooltip="tooltip" data-placement="top" title="Selfie photos are mirrored in live view. Select this to flip the image after the photo is taken."><i class="fas fa-question-circle ml-1" ></i></a></div>
												
											</div>
										</div>	 
										
										<div class="col-sm-4 mt-2">
											<div class="form-group row d-flex align-items-center">
												<div class="col-sm-3 mt-2">
													<div class="switchToggle">
														<input type="checkbox" id="allowLibrarySelect" name="allowLibrarySelect" value="1"> 
														<label for="allowLibrarySelect">Off</label> 
													</div>
												</div> 
												<div class="col-sm-9 pr-0 ">Select Photo <a href="#" data-tooltip="tooltip" data-placement="top" title="Allow users to choose between taking a photo with the camera or selecting an existing photo from their device."><i class="fas fa-question-circle ml-1" ></i></a></div>
												
											</div>
										</div>
										
									</div>
									
									
									
									
									
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label" style="padding-right:0;">Disclaimer</label>
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="enableDisclaimer" name="enableDisclaimer" value="1"> 
												<label for="enableDisclaimer">Off</label>  
											</div>									
										</div>								
										
									</div>
									
									<div class="accordion" id="accordionExampleS5">
										<div class="col-lg-12 mx-auto mb-4">
											<div class="card">
												<div class="card-header" id="headingThreeS5">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThreeS5" aria-expanded="false" aria-controls="collapseThreeS5">Disclaimer Text</a><i class="fas fa-chevron-right float-right"></i>                     
													</h2>
												</div>
												<div id="collapseThreeS5" class="collapse" aria-labelledby="headingThreeS5" data-parent="#accordionExampleS5">
													<div class="card-body">
													<div class="col-sm-12 pl-4 pr-4">
														 <textarea name="disclaimerText" id="disclaimerText" class="messages" rows="5"></textarea>
													</div>	
													</div>
												</div>
											</div>
											
										</div>
									</div>	
									<!--Options End-->
								</div>
								<!--Standard End-->
								<!--Text Start-->
								<div class="tab-pane fade" id="text">

									<div class="row">
									
										<div class="col-lg-12 mx-auto">
											
													
											<div id="form-name" class="form-group row sect-head">
												<label for="name" class="col-sm-3 col-form-label">Buttons</label>
											</div>
											
																			
											<div id="form-type" class="form-group row" >	

												<div class="col-sm-6 ml-4 mr-3 pr-0">
													<div class="form-group row">
														<label class="col-sm-4 pl-2 col-form-label">Start</label>
														<div class="col-sm-7 ml-0 pl-0">
															<input type="text" class="form-control" id="startButtonText" value="Start Booth" name="startButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 pl-2 col-form-label">Take Photo</label>
														<div class="col-sm-7 ml-0 pl-0">
															<input type="text" class="form-control" id="photoButtonText" value="Take Photo" name="photoButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 pl-2 col-form-label">Camera</label>
														<div class="col-sm-7 ml-0 pl-0">
															<input type="text" class="form-control" id="cameraButtonText" value="Take Photo" name="cameraButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 pl-2 col-form-label">Select</label>
														<div class="col-sm-7 ml-0 pl-0">
															<input type="text" class="form-control" id="libraryButtonText" value="Take Photo" name="libraryButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 pl-2 col-form-label">Done</label>
														<div class="col-sm-7 ml-0 pl-0">
															<input type="text" class="form-control" id="doneButtonText" value="Done" name="doneButtonText" >
														</div>
													</div>
												</div>
												
												<div class="col-sm-5 ml-0 pl-0 limit-sm6">
												<div class="form-group row">
														<label class="col-sm-3 ml-3 col-form-label">Accept</label>
														<div class="col-sm-8 ml-0 pl-0 limit-sm7">
															<input type="text" class="form-control" id="likeButtonText" value="I Like it" name="likeButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 ml-3 col-form-label">Retake</label>
														<div class="col-sm-8 ml-0 pl-0 limit-sm7">
															<input type="text" class="form-control" id="retakeButtonText" value="Retake Photo" name="retakeButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 ml-3 col-form-label">Next</label>
														<div class="col-sm-8 ml-0 pl-0 limit-sm7">
															<input type="text" class="form-control" id="nextButtonText" value="Next" name="nextButtonText" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 ml-3 col-form-label">Send</label>
														<div class="col-sm-8 ml-0 pl-0 limit-sm7">
															<input type="text" class="form-control" id="sendButtonText" value="Send" name="sendButtonText" >
														</div>
													</div>
													
													
												</div>
											</div>
											
											<div id="form-name" class="form-group row  sect-head">
												<label for="name" class="col-sm-3 col-form-label">Instructions</label>
											</div>
											<div id="form-sharing" class="form-group row ml-1">
													<label class="col-sm-2 pr-0 col-form-label">Frames</label>
													<div class="col-sm-4 ">
														
														<input type="text" class="form-control tes" id="instruction_frameText" value="Select a Frame" name="instruction_frameText" >
													</div>
											</div>
											
											<div id="form-sharing" class="form-group row ml-1">
												<label class="col-sm-2 pr-0 col-form-label">Backgrounds</label>
												<div class="col-sm-4 ">
													<input type="text" class="form-control" id="instruction_bgText" value="Select a Background" name="instruction_bgText" >
												</div>
											</div>
											<div id="form-sharing" class="form-group row ml-1">
												<label class="col-sm-2 pr-0 col-form-label">Sticker</label>
												<div class="col-sm-4 ">
													<input type="text" class="form-control" id="instruction_stickerText" value="Add Stickers" name="instruction_stickerText" >
												</div>
											</div>
											<div id="form-sharing" class="form-group row ml-1">
												<label class="col-sm-2 pr-0 col-form-label">Filters</label>
												<div class="col-sm-4 ">
													<input type="text" class="form-control" id="instruction_filterText" value="Select a Filter" name="instruction_filterText" >
												</div>
											</div>
										</div>
												
									</div>
									
									
								</div>
								<!--Text End-->
								<!--Style Start-->
								<div class="tab-pane fade" id="styles" role="tabpanel" aria-labelledby="styles-tab">
									<div id="form-name" class="form-group row">
										<label for="name" class="col-sm-3 col-form-label">Design</label>
									</div>
									<div class="col-lg-12 mx-auto mb-4">
										<div class="accordion" id="accordionExampleI">
											<div class="card">
												<div class="card-header" id="headingOneI">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a class="btn btn-link" data-toggle="collapse" data-target="#collapseOneI" aria-expanded="true" aria-controls="collapseOneI">Logo</a><i class="fas fa-chevron-right float-right"></i>				
															</h2>
														</div>
													</div>
												</div>
												<div id="collapseOneI" class="collapse " aria-labelledby="headingOneI" data-parent="#accordionExampleI">
													<div class="card-body">
														<div id="form-images" class="form-group row mb-4">
															<label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-left:32px;">Logo <i class="fas fa-question-circle ml-1" style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="<div class='text-justify'><b>Format</b>: .png<br><b>Max width</b>: 400	<br><b>DPI</b>: 72</div>"></i></label>
															<div class="col-sm-3">
																<div class="preview-zone logo hidden text-left">
																  <div class="box box-solid">
																	<div class="box-header logo with-border" style="display:none;">
																	  <div class="box-tools pull-right">
																		<a href="#" class="dz-remove  btn-xs remove-preview remove-logo">
																		  <i class="fa fa-times"></i>
																		</a>
																	  </div>
																	</div>
																	<div class="box-body logo"  id="pz-logoImage"></div>
																  </div>
																</div>
																
																<div id="logo" class="dropzone-wrapper logo" style="width:200px;height:100px;">
																  <div class="dropzone-desc logo" style="top:10px;">
																	<i class="glyphicon glyphicon-download-alt"></i>
																	<p>Choose an image.</p>
																	<p class="dimDisplay photo">Max width 400px</p>
																  </div>

																 <input type="file" name="dz-logo" id="dz-logo" class="dropzoneSingle" accept=".png,.jpg" />
																  <input name="logoImage" class="fileField" id="logoImage" type="hidden"  />
																  <input name="logo-width" id="logo-width" type="hidden" value="0" />
																  <input name="logo-height" id="logo-height" type="hidden" value="0"/>
																</div>
															</div>
														</div>
													
														<div id="form-images" class="form-group row mt-1">
															<label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-left:32px;">Logo Position</label>
															<div class="col-sm-9">
																
																<select class="selectpicker logo-position" data-width="auto" name="logoPosition">
																  <option value="top">Booth Top</option>
																  <option value="image-top">Start Screen Top</option>
																  <option value="image-mid">Start Screen Middle</option>
																  <option value="image-bottom">Start Screen Bottom</option>
																  <option value="bottom">Booth Bottom</option>
																  <option value="page-bottom">Page Bottom</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingTwoI">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a  id="accordian-start" class="btn btn-link" data-toggle="collapse" data-target="#collapse-start" aria-expanded="true" aria-controls="collapse-start">Start Screen</a><i class="fas fa-chevron-right float-right"></i>		
															</h2>
														</div>
													</div>
												</div>
												<div id="collapse-start" class="collapse show" id="accordian-start" aria-labelledby="headingTwoI" data-parent="#accordionExampleI">
													<div class="card-body">
														<div id="form-images" class="form-group row">
															<div class="col-sm-3 ml-3 d-flex justify-content-center">
																<div class="row justify-content-center"> 
																	<div class="mx-auto">
																		<label for="start" class="limit-sm7 col-form-label">Start Screen <i class="fas fa-question-circle ml-1" style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="<div class='text-justify'><b>Format</b>: .png<br><b>Size-Square</b>: 600x600 <br><b>Size-Portrait</b>: 400x600<br><b>DPI</b>: 72</div>"></i></label>
																	</div>
																	<div class="preview-zone splash hidden">
																	  <div class="box box-solid">
																		<div class="box-header splash with-border" style="display:none;">
																		  <div class="box-tools pull-right" >
																			<a href="#" class="dz-remove  remove-preview remove-splash">
																			  <i class="fa fa-times"></i>
																			</a>
																		  </div>
																		</div>
																		<div class="box-body splash" id="pz-startImage"></div>
																	  </div>
																	  
																	</div>
																	<input type="file" name="dz-start" id="dz-start" class="dropzoneSingle" accept=".png,.jpg" />
																	  <input name="startImage" class="fileField" id="startImage" type="hidden"  />
																	  <input name="start-width" id="start-width" type="hidden" value="0" />
																	  <input name="start-height" id="start-height" type="hidden" value="0" />
																	<div id="splash" class="dropzone-wrapper photo splash">
																	  <div class="dropzone-desc splash">
																		<i class="glyphicon glyphicon-download-alt"></i>
																		<p>Choose an image.</p>
																		<p class="dimDisplay photo photo-s">600px x 600px</p>
																	  </div>

																
																	</div>
																</div>
															</div>
															<div class="col-sm-8 ml-3 pr-0 ">
																<div class="row justify-content-center"> 
																	<div class="col-sm-6 margin-auto">
																		<label for="start" class="limit-sm7 col-form-label">Extra Start Screen Text</label>
																	</div>
																	
																</div>
																<div id="form-name" class="row">
																	<div class="col-sm-12 pr-0">
																		 <textarea style="display:none;" name="splashMessage" id="splashMessage" class="messages"></textarea> 
																	</div>
																</div>	
																<div id="form-name" class="row mt-3">
																	<div class="col-sm-4 d-flex align-items-center pr-0 col-form-label">
																		Frame Text
																	</div>
																	<div class="col-sm-5 pl-0">
																		<div class="col-sm-1 mt-2 limit-sm">
																			<div class="switchToggle">
																				<input type="checkbox" id="frameStartText" name="frameStartText" value="1"> 
																				<label for="frameStartText">Off</label>  
																			</div>			 						
																		</div>	
																	</div>
																</div>
																<div id="form-name" class="row mt-3">
																	<div class="col-sm-4 d-flex align-items-center pr-0 col-form-label">
																		Text Position
																	</div>
																	<div class="col-sm-5 pl-0">
																		<select class="selectpicker splash-position" data-width="auto" name="splashMessagePosition" >
																		  <option value="top">Booth Top</option>
																		  <option value="image-top">Start Screen Top</option>
																		  <option value="image-mid">Start Screen Middle</option>
																		  <option value="image-bottom">Start Screen Bottom</option>
																		  <option value="bottom">Booth Bottom</option>
																		  </select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingThreeI">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a id="accordian-thanks" class="btn btn-link" data-toggle="collapse" data-target="#collapse-thanks" aria-expanded="true" aria-controls="collapse-thanks">Thanks Screen</a><i class="fas fa-chevron-right float-right"></i>	
															</h2>
														</div>
													</div>
												</div>
												<div id="collapse-thanks" class="collapse" id="accordian-thanks" aria-labelledby="headingThreeI" data-parent="#accordionExampleI">
													<div class="card-body">
														<div id="form-images" class="form-group row">
															<div class="col-sm-3 ml-3 d-flex justify-content-center">
																<div class="row justify-content-center"> 
																	<div class="mx-auto">
																		<label for="thanks" class="col-form-label">Thanks Screen <i class="fas fa-question-circle ml-1" style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="<div class='text-justify'><b>Format</b>: .png<br><b>Size-Square</b>: 600x600 <br><b>Size-Portrait</b>: 400x600<br><b>DPI</b>: 72</div>"></i></label>
																	</div>
																	<div class="preview-zone thanks hidden">
																	  <div class="box box-solid">
																		<div class="box-header thanks with-border" style="display:none;">

																		  <div class="box-tools pull-right" >
																			<a href="#" class="dz-remove remove-preview remove-thanks">
																			  <i class="fa fa-times"></i>
																			</a>
																		  </div>
																		</div>
																		<div class="box-body thanks"  id="pz-thanksImage"></div>
																	  </div>
																	</div>
																	<div class="dropzone-wrapper photo thanks">
																	  <div class="dropzone-desc thanks">
																		<i class="glyphicon glyphicon-download-alt"></i>
																		<p>Choose an image.</p>
																		<p class="dimDisplay photo photo-s">600px x 600px</p>
																	  </div>
																	<input type="file" name="dz-thanks" id="dz-thanks" class="dropzoneSingle" accept=".png,.jpg"  />
																	  <input name="thanksImage" class="fileField"  id="thanksImage" type="hidden" />
																	  <input name="thanks-width" id="thanks-width" type="hidden" value="0" />
																	  <input name="thanks-height" id="thanks-height" type="hidden" value="0" />
																	</div>
																</div>
															</div>
															<div class="col-sm-8 ml-3 pr-0 ">
																<div class="row justify-content-center"> 
																	<div class="col-sm-6 margin-auto">
																		<label for="start" class="limit-sm7 col-form-label">Extra Thanks Screen Text</label>
																	</div>
																	
																</div>
																<div id="form-name" class="row">
																	<div class="col-sm-12 pr-0">
																		 <textarea name="thanksMessage" id="thanksMessage" class="messages"></textarea>
																	</div>
																</div>	
																<div id="form-name" class="row mt-3">
																	<div class="col-sm-4 d-flex align-items-center pr-0 col-form-label">
																			Frame Text
																		</div>
																	<div class="switchToggle">
																		<input type="checkbox" id="frameThanksText" name="frameThanksText" value="0"> 
																		<label for="frameThanksText">Off</label>  
																	</div>
																</div>
																<div id="form-name" class="row mt-3">
																	<div class="col-sm-4 d-flex align-items-center pr-0 col-form-label">
																		Text Position
																	</div>
																	<div class="col-sm-5 pl-0">
																		<select class="selectpicker thanks-position" data-width="auto" name="thanksMessagePosition" >
																		  <option value="top">Booth Top</option>
																		  <option value="image-top">Thanks Screen Top</option>
																		  <option value="image-mid">Thanks Screen Middle</option>
																		  <option value="image-bottom">Thanks Screen Bottom</option>
																		  <option value="bottom">Booth Bottom</option>
																		  </select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingFourI">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a class="btn btn-link" id="accordian-background" data-toggle="collapse" data-target="#collapseFourI" aria-expanded="true" aria-controls="collapseFourI">Page Background</a><i class="fas fa-chevron-right float-right"></i>				
															</h2>
														</div>
													</div>
												</div>
												<div id="collapseFourI" class="collapse " aria-labelledby="headingFourI" data-parent="#accordionExampleI">
													<div class="card-body">
														<div id="form-bgImage" class="form-group row">
															<label for="bgImage" class="col-sm-4 col-form-label" style="padding-left:32px;">Background Image<i class="fas fa-question-circle ml-1" style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="<div class='text-justify'><b>Format</b>: .jpg<br><b>Size</b>: 1920x1080<br><b>DPI</b>: 72</div>"></i></label>
															<div class="col-sm-3">
															
																<div class="preview-zone bgImage hidden text-left">
																  <div class="box box-solid">
																	<div class="box-header bgImage with-border" style="display:none;">
																	  <div class="box-tools pull-right" >
																		<a href="#" class="dz-remove remove-preview remove-bgImage">
																		  <i class="fa fa-times"></i>
																		</a>
																	  </div>
																	</div>
																	<div class="box-body bgImage"  id="pz-bgImage"></div>
																  </div>
																</div>
																<input name="event_image" class="fileField" id="event_image" type="hidden" />
																  <input name="bgImage-width" id="bgImage-width" type="hidden" value="0" />
																  <input name="bgImage-height" id="bgImage-height" type="hidden"  value="0"/>
																<div id="bgg_img" class="dropzone-wrapper bgImage " style="width:266px;height:150px;">
																  <div class="dropzone-desc bgImage">
																	<i class="glyphicon glyphicon-download-alt"></i>
																	<p>Choose an image.</p>
																	<p class="dimDisplay bgImage"></p>
																  </div>

																  <input type="file" name="dz-bgImage" id="dz-bgImage" class="dropzoneSingle" accept=".png,.jpg">
																 
																</div>
															</div>
														</div>
														<div id="form-name" class="form-group row pt-3">
															<label for="name" class="col-sm-4 col-form-label" style="padding-left:32px;">Overlay Color</label>
															<div class="col-sm-5">
																 <input type="hidden" id="bgOverlayColor" name="bgOverlayColor" class="form-control" value="rgba(0, 0, 0, 0)" />
															</div>
														</div>
														<div id="form-name" class="form-group row pt-3">
															<label for="name" class="col-sm-4 col-form-label" style="padding-left:32px;">Background Color</label>
															<div class="col-sm-3">
																 <input type="text" id="bgColor-tmp" name="bgColor-tmp" class="form-control" value=""/>
																 <input type="hidden" id="bgColor" name="bgColor" class="form-control" value=""/>
															</div>
														</div>
														<div id="form-name" class="form-group row">
															<label for="name" class="col-sm-4 col-form-label" style="padding-left:32px;">Background Animation</label>
															<div class="col-sm-6">
																<select class="selectpicker bgAnimation" data-width="200px" name="bgAnimation" > 
																  <option value="none">None</option>
																  <option value="gradient">Animated Gradient</option>
																  <option value="balloons">Balloons</option>
																  <option value="beer">Beer</option>
																  <option value="bokeh">Bokeh</option>
																  <option value="bubbles">Bubbles</option>
																  <option value="champagne">Champagne</option>
																  <option value="clouds">Clouds</option>
																  <option value="confetti">Confetti</option>
																  <option value="diagonals">Diagonals</option>
																  <option value="drip">Drip</option>
																  <option value="fireflies">Fireflies</option>
																  <option value="fireworks2">Fireworks</option>
																  <option value="fog">Fog</option>
																  <option value="lava">Lava Lamp</option>
																  <option value="mario">Mario</option>
																  <option value="nightsky">Night Sky</option>
																  <option value="plasma">Plasma</option>
																  <option value="searchlights">Search Lights</option>
																  <option value="snow">Snow</option>
																  <option value="spotlight">Spotlight</option>
																  <option value="stars">Stars</option>	
																  <option value="waves">Waves</option>	
																  </select>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingFiveI">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a class="btn btn-link" data-toggle="collapse" data-target="#collapseFiveI" aria-expanded="true" aria-controls="collapseFiveI">Buttons</a><i class="fas fa-chevron-right float-right"></i>				
															</h2>
														</div>
														
													</div>
												</div>
												<div id="collapseFiveI" class="collapse " aria-labelledby="headingFiveI" data-parent="#accordionExampleI">
													<div class="card-body">
														<div id="form-bgImage">
															<div id="form-name" class="form-group row">
																<div class="col-sm-6">
																	<div  class="form-group row">
																		<div class="col-sm-6 d-flex align-items-center pr-0 col-form-label">
																			Button Style
																		</div>
																		<div class="col-sm-5">
																			<select class="selectpicker button-style" data-width="auto" name="buttonStyle" id="buttonStyle"> 
																			  <option value="button-cust-normal">Normal</option>
																			  <option value="button-cust-3d2">3D</option>
																			  <option value="button-cust-outline2">Basic Outline</option>
																			  <option value="button-cust-real">Block</option> 
																			  <option value="button-cust-outline">Boxy</option> 
																			  <option value="button-cust-circle">Circle</option> 
																			  <option value="button-cust-gradient">Circle Gradient</option> 
																			  <option value="button-cust-3d">Glow</option>
																			  <option value="button-cust-hand-dashed">Hand Dashed</option> 
																			  <option value="button-cust-hand-dotted">Hand Dotted</option>
																			  <option value="button-cust-hand-thick">Hand Thick</option> 
																			  <option value="button-cust-hand-thin">Hand Thin</option> 
																			  <option value="button-cust-nice">Parallel Lines</option>  
																			  <option value="button-cust-float">Pill</option> 
																			  <option value="button-cust-press">Press Me</option> 
																			  <option value="button-cust-squareish">Squareish</option> 
																			  <option value="button-cust-tear">Tear Drop</option> 
																			  </select>
																		</div>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div  class="form-group row">
																		<div class="col-sm-6 d-flex align-items-center pr-0 col-form-label">
																			Button Position
																		</div>
																	
																		<div class="col-sm-6">
																			<select class="selectpicker button-position" data-width="auto" name="buttonPosition" > 
																			  
																			  <option value="image-top">Image Top</option>
																			  <option value="image-mid">Image Middle</option>
																			  <option value="image-bottom">Image Bottom</option>
																			  <option value="bottom">Booth Bottom</option>
																			  <option value="page-bottom">Page Bottom</option>
																			  </select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<div class="col-sm-6">
																	<div id="form-buttonColor" class="form-group row">
																		<div class="col-sm-6 d-flex align-items-center pr-0 col-form-label">
																		Button Color
																	</div>
																		<div class="col-sm-6">
																			 <input type="text" id="buttonColor" name="buttonColor" class="form-control" value="#6c757d"/>
																		</div>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div id="form-textColor" class="form-group row">
																		<div class="col-sm-6 d-flex align-items-center pr-0 col-form-label">
																			Button Text Color
																		</div>
																		<div class="col-sm-6">
																			 <input type="text" id="textColor" name="textColor" class="form-control" value="#FFFFFF"/>
																		</div>
																	</div>
																</div>
															</div>
														
															<div id="form-name" class="form-group row">
																
																<div class="col-sm-6">
																	<div  class="form-group row">
																		<div class="col-sm-6 d-flex align-items-center pr-0 col-form-label">
																			Button Icon
																		</div>
																		
																		<div class="col-sm-6 mt-2">
																			<div class="switchToggle">
																				<input type="checkbox" id="showButtonIcon" name="showButtonIcon" value="1" > 
																				<label for="showButtonIcon">Off</label> 
																			</div>	
																		</div>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="row">
																		<label class="col-sm-6 col-form-label">Hide Start Button<br><small>(Click image to start)</small></label>
																		<div class="col-sm-6 mt-2">
																			<div class="switchToggle">
																				<input type="checkbox" id="hideStart" name="hideStart" value="1"> 
																				<label for="hideStart">Off</label> 
																			</div>	
																		</div>
																	</div>
																</div>
															</div>
															
															
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
								
								 <!--Style End-->

								<!--Sharing Start-->
								<div class="tab-pane fade" id="sharing">
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label">Sharing</label>
										
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingEmail" name="sharingEmail" value="1"> 
												<label for="sharingEmail">Off</label> 
											</div>									
										</div>								
										<div class="col-sm-1 ml-0 pl-2 mr-0 pr-0 limit-sm">Email</div>
										
										<div class="col-sm-1 mt-2 ml-0 pl-1 limit-sm3">
											<div class="switchToggle">
												<input type="checkbox" id="sharingFacebook" name="sharingFacebook" value="1"> 
												<label for="sharingFacebook">Off</label> 
											</div>
											
										</div>
										<div class="col-sm-1 ml-0 pl-0 mr-0 pr-0 limit-sm">Facebook</div>
										 
										<div class="col-sm-1 mt-2 pl-3 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingTwitter" name="sharingTwitter" value="1" > 
												<label for="sharingTwitter">Off</label> 
											</div>
										</div>
										<div class="col-sm-1  ml-0 pl-2 mr-0 pr-0 limit-sm">Twitter</div>
										
										<div class="col-sm-1 mt-2 pl-3 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingDownload" name="sharingDownload" value="1" > 
												<label for="sharingDownload">Off</label> 
											</div>
										</div>
										<div class="col-sm-1  ml-0 pl-2 mr-0 pr-0 limit-sm">Download</div>
										
										
									</div>
									<div class="col-lg-12 mx-auto mb-4">
										<div class="accordion" id="accordionExampleS">
											<div class="card">
												<div class="card-header" id="headingOneS">
													<div class="row">
													
														<div class="col-sm-12">
															<h2 class="clearfix mb-0">
																<a class="btn btn-link" data-toggle="collapse" id="accordian-frames" data-target="#collapseOneS" aria-expanded="true" aria-controls="collapseOneS">Email Options </a><i class="fas fa-chevron-right float-right"></i>				
															</h2>
														</div>
													</div>
												</div>
												<div id="collapseOneS" class="collapse show" aria-labelledby="headingOneS" data-parent="#accordionExampleS">
													<div class="card-body">
														
														<div id="form-sharing" class="form-group row">
															<label for="emailSubject" class="col-sm-3 col-form-label pr-0">Email Subject</label>
															<div class="col-sm-8">
															<input type="text" class="form-control" id="emailSubject" value="Here's Your Photo" name="emailSubject" >
															</div>
														</div>	
														<div id="form-email" class="form-group row">
															<label for="emailMessage" class="col-sm-3 col-form-label pr-0">Email Message</label>
															<div class="col-sm-8">
																<textarea id="emailMessage" name="emailMessage" style="min-width: 100%;border-color: #ced4da;" rows="5">Here's your Photo.</textarea>
															</div>
														</div>
														<div id="form-type" class="form-group row  d-flex align-items-center">
															<label class="col-sm-3 col-form-label">Require Email</label>
																
															<div class="col-sm-1 mt-2">
																<div class="switchToggle">
																	<input type="checkbox" id="requireEmail" name="requireEmail" value="1"> 
																	<label for="requireEmail">Off</label> 
																</div>									
															</div>	
														</div>	
													</div>
													 
												</div>
											</div>
											
											<div class="card">
												<div class="card-header" id="headingTwoS">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwoS" aria-expanded="false" aria-controls="collapseTwoS">Facebook & Twitter Options</a><i class="fas fa-chevron-right float-right"></i>
													</h2>
												</div>
												<div id="collapseTwoS" class="collapse" aria-labelledby="headingTwoS" data-parent="#accordionExampleS">
													<div class="card-body">
														<div id="form-sharing" class="form-group row">
															<label for="sharingMessage" class="col-sm-3 col-form-label pr-0">Social Message</label>
															
															<div class="col-sm-8">
																<textarea id="sharingMessage" name="sharingMessage" style="min-width: 100%;border-color: #ced4da;" rows="5">Check out my Photo</textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label" style="padding-right:0;">Automatic Uploads<i class="fas fa-question-circle ml-1 " style="font-size:16px;top:0;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="Photos will be uploaded to the selected services. Configure Dropbox and Google Drive in the Integrations tab in the main menu."></i></label>
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingGallery" name="sharingGallery" value="1"> 
												<label for="sharingGallery">Off</label> 
											</div>									
										</div>								
										<div class="col-sm-1 ml-0 pl-2 mr-0 pr-0 limit-sm">Gallery</div>
																				<div class="col-sm-1 mt-2 pl-1 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingDropbox" name="sharingDropbox" value="1" > 
												<label for="sharingDropbox">Off</label> 
											</div>
										</div>
										
																				
										<div class="col-sm-1 ml-0 pl-0 mr-0 pr-0 limit-sm">Dropbox</div>
										
																				
										<div class="col-sm-1 mt-2 pl-1 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="sharingGoogle" name="sharingGoogle" value="1" > 
												<label for="sharingGoogle">Off</label> 
											</div>
										</div>
																				
										<div class="col-sm-2 ml-0 pl-0 mr-0 pr-0 limit-sm">Google</div>
									</div>
									<div class="accordion" id="accordionExampleS2">
										<div class="col-lg-12 mx-auto mb-4">
											<div class="card">
												<div class="card-header" id="headingThreeS2">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThreeS2" aria-expanded="false" aria-controls="collapseThreeS2">Gallery Options</a><i class="fas fa-chevron-right float-right"></i>                     
													</h2>
												</div>
												<div id="collapseThreeS2" class="collapse" aria-labelledby="headingThreeS2" data-parent="#accordionExampleS2">
													<div class="card-body">
														<div id="form-type" class="form-group row  d-flex align-items-center">
															<label class="col-sm-4 col-form-label">Ask to add to Gallery</label>
																
															<div class="col-sm-1 mt-2">
																<div class="switchToggle">
																	<input type="checkbox" id="askToShare" name="askToShare" value="1"> 
																	<label for="askToShare">Off</label> 
																</div>									
															</div>	
														</div>		
														<div id="form-sharing" class="form-group row">
															<label for="emailSubject" class="col-sm-4 col-form-label pr-0">Gallery Question Text</label>
															<div class="col-sm-8">
															<input type="text" class="form-control" id="askToShareText" value="Can we add your photo to our online gallery?" name="askToShareText" >
															</div>
														</div>	
														<div id="form-type" class="form-group row  d-flex align-items-center">
															<label class="col-sm-4 col-form-label">Hide Gallery Button<i class="fas fa-question-circle " style="font-size:16px;top:0;margin-left: 0.12rem !important;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="Hide the link to the gallery on the sharing page but still upload the photo to the gallery."></i></label>
																
															<div class="col-sm-1 mt-2">
																<div class="switchToggle">
																	<input type="checkbox" id="hideGalleryButton" name="hideGalleryButton" value="1"> 
																	<label for="hideGalleryButton">Off</label> 
																</div>									
															</div>	
														</div>
													</div>
												</div>
											</div>
											
										</div>
									</div>	
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label" style="padding-right:0;">Call to Action Button<i class="fas fa-question-circle " style="font-size:16px;top:0;margin-left: 0.12rem !important;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="Button shown at bottom of Photo Sharing Page that links to an external URL."></i></label>
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="enableCTA" name="enableCTA" value="1"> 
												<label for="enableCTA">Off</label>  
											</div>									
										</div>								
										
									</div>
									<div class="accordion" id="accordionExampleS3">
										<div class="col-lg-12 mx-auto mb-4">
											<div class="card">
												<div class="card-header" id="headingThreeS3">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThreeS3" aria-expanded="false" aria-controls="collapseThreeS3">Call to Action Options</a><i class="fas fa-chevron-right float-right"></i>                     
													</h2>
												</div>
												<div id="collapseThreeS3" class="collapse" aria-labelledby="headingThreeS3" data-parent="#accordionExampleS3">
													<div class="card-body">
														<div class="form-group row d-flex align-items-center">
															<label class="col-sm-3 col-form-label">Call to Action Text</label>
															<div class="col-sm-8 ml-0 pl-0 limit-sm7">
																<input type="text" class="form-control" id="CTAButtonText" value="Send" name="CTAButtonText" >
															</div>
														</div>		
														<div class="form-group row d-flex align-items-center">
															<label class="col-sm-3 col-form-label">Call to Action URL</label>
															<div class="col-sm-8 ml-0 pl-0 limit-sm7">
																<input type="text" class="form-control" id="CTAButtonURL" value="https://www.virtualbooth.me" name="CTAButtonURL" >
															</div>
														</div>
														
													</div>
												</div>
											</div>
											
										</div>
									</div>	
									<div id="form-type" class="form-group row  d-flex align-items-center">
										<label class="col-sm-3 col-form-label" style="padding-right:0;">Buy Prints<i class="fas fa-question-circle " style="font-size:16px;top:0;margin-left: 0.12rem !important;" href="#" data-tooltip="tooltip" data-placement="top" data-html="true" title="Allow users to purchase copies of their photos from our print partner."></i></label>
										<div class="col-sm-1 mt-2 limit-sm">
											<div class="switchToggle">
												<input type="checkbox" id="enableBuy" name="enableBuy" value="1"> 
												<label for="enableBuy">Off</label>  
											</div>			 						
										</div>								
										
									</div>
									<div class="accordion" id="accordionExampleS4">
										<div class="col-lg-12 mx-auto mb-4">
											<div class="card">
												<div class="card-header" id="headingThreeS4">
													<h2 class="mb-0">
														<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThreeS4" aria-expanded="false" aria-controls="collapseThreeS4">Buy Options</a><i class="fas fa-chevron-right float-right"></i>                     
													</h2>
												</div>
												<div id="collapseThreeS4" class="collapse" aria-labelledby="headingThreeS4" data-parent="#accordionExampleS4">
													<div class="card-body">
														<div class="form-group row d-flex align-items-center">
															<label class="col-sm-3 col-form-label">Buy Button Text</label>
															<div class="col-sm-8 ml-0 pl-0 limit-sm7">
																<input type="text" class="form-control" id="BuyButtonText" value="Buy Prints" name="BuyButtonText" >
															</div>
														</div>		
														
														
													</div>
												</div>
											</div>
											
										</div>
									</div>	
									
									
								</div>
								<!--Text End-->
								<!--Whitelabel Start-->
								<div class="tab-pane fade" id="whitelabel">
									<!--Domain Start-->
									<div id="form-whitelabelurl" class="form-group row">
										<div class="col-sm-3 mr-0 pr-0">
											<!-- <div class="input-group align-items-center limit-sm8">
												<label for="whitelabelurl" class="col-form-label">White Label URL</label>
												<input type="radio" name="whitelabelurl" value="none" class="ml-auto mr-0" checked>
											</div> -->
										</div>
										<div class="col-sm-7 align-self-center">
											None
										</div>
										
									</div>
									<div id="form-whitelabelurl" class="form-group row">
										<!-- <div class="col-sm-3 mr-0 pr-0">
											<div class="input-group align-items-center" >										
												<input type="radio" name="whitelabelurl" value="default" class="ml-auto mr-0" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled>
																							</div>
										</div> -->
										
										<div class="col-sm-4 pl-0 align-self-end">
											<span>.stemx.com</span>
										</div>
									</div>
									<div class="row pb-3 d-none">
										<div class="col-sm-3 mr-0 pr-0">
											<!-- <div class="input-group align-items-center">
												<label class="col-form-label"> </label>
																									<input type="radio" name="whitelabelurl" value="custom" class="ml-auto mr-0" data-tooltip="tooltip" data-placement="top" title="Upgrade required"  disabled>
																								
											</div> -->
										</div>
										<div class="col-sm-3">
																							<input type="text" class="form-control" id="whitelabel-subdomain" place-holder="mysubdomain" name="whitelabelsubdomain" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																						
										</div>
										<div class="col-sm-4 pl-0">
											<div class="input-group">
												<span class="align-self-end mr-2" style="width:10px;">.</span>
																									<input type="text" class="form-control" id="whitelabel-domain" place-holder="mydomain.com" name="whitelabeldomain" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																							
											</div>
										</div>
										<div class="col-sm-2 pl-0 align-self-end">
																							<a href="#" class="btn btn-light btn-sm"  data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled>Verify</a>
																					</div>
									</div>
									<div id="popover_title_url" style="display: none">
										White Label URL Verification<a href="#" onclick="$(this).closest('div.popover').popover('hide');$('.fa-check').hide();$('.fa-ban').hide();" class="close-popover float-right text-white"><i class="fas fa-times"></i></a>
									</div>
									<div id="popover_content_url" style="display:none;">
									Please add the following CNAME Record to the DNS file of your domain. 
									<table class="table">
										 <thead>
										 <tr>
											 <th>Type</th>
											 <th>Host</th>
											 <th>Points to</th>
											 <th class="text-center">Validated</th>
										 </tr>
										 </thead>

										 <tbody >
										 <tr>
											 <td>CNAME</td>
											 <td id='urlToValidate'></td>
											 <td>stemx.com</td>
											 <td class="text-center">
												<span id="domainDomainCheck" class="fas fa-check ml-2" style="color:green;display:none;"></span>
												<span id="domainDomainX" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
											 </td>
										 </tr>
										 </tbody>
									 </table>
									 </div>
									<!--<div class="row pb-3" style="margin-top:-15px;">
										<div class="col-sm-8 offset-3">
											<span class="small"><span id="domainPrefix">mybrand</span>.<span id="domainDomain">stemx.com</span></span>
											
										</div>
									</div>
									-->
									<!--Domain End-->
									
									<!--Email Start-->
									<div id="form-whitelabelbrand" class="form-group row">
										<div class="col-sm-3 mr-0 pr-0">
											<!-- <div class="input-group align-items-center">
												<label for="whitelabelbrands" class="col-form-label">White Label Email</label>
												<input type="radio" name="whitelabelbrands" value="none" class="ml-auto mr-0" checked>
											</div> -->
										</div>
										<div class="col-sm-7 align-self-center">
											None
										</div>
										
									</div>

										<div class="col-sm-3">
																							<input type="text" class="form-control" id="whitelabel-defaultemail" place-holder="mybrand" name="whitelabeldefaultemail" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																							
										</div>
										<div class="col-sm-4 pl-0 align-self-end">
											<span>@stemx.com</span>
										</div>
									</div>
									<div class="row pb-3">
										<div class="col-sm-3 mr-0 pr-0">
											<div class="input-group align-items-center">
												<label for="whitelabelemail" class="col-form-label">&nbsp;</label>
																								<input type="radio" name="whitelabelemail" value="custom" class="ml-auto mr-0" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																						
											</div>
										</div>
										<div class="col-sm-7">
																							<input type="text" class="form-control" id="whitelabel-customemail" place-holder="myemail@mydomain.com" name="whitelabelcustomemail" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																						
										</div>
										
										<div class="col-sm-2 pl-0 align-self-end">
																							<a href="#" class="btn btn-light btn-sm"  data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled>Verify</a>
																						
										</div>
									</div>
									<div id="popover_title_email" style="display: none">
										White Label Email Verification<a href="#" onclick="$(this).closest('div.popover').popover('hide');$('.fa-check').hide();$('.fa-ban').hide();" class="close-popover float-right text-white"><i class="fas fa-times"></i></a>
									</div>
									<div id="popover_content_email" style="display:none;">
									<p>An email has been sent to <b><span class="emailToValidate"></span></b>. Please click on the included link to verify ownership.</p>
									<table class="table">
										 <thead>
										 <tr>
											 <th>Email</th>
											 <th class="text-center">Validated</th>
										 </tr>
										 </thead>

										 <tbody>
										 <tr>
											 <td class='emailToValidate'></td>
											 <td class="text-center">
												<span id="emailDomainCheck" class="fas fa-check ml-2" style="color:green;display:none;"></span>
												<span id="emailDomainX" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
											 </td>
										 </tr>
										 </tbody>
									 </table>
									<p>Please add the following CNAME Record to the DNS file of your domain. </p>
									<table class="table">
										 <thead>
										 <tr>
											 <th>Type</th>
											 <th>Host</th>
											 <th>Points to</th>
											 <th>Validated</th>
										 </tr>
										 </thead>

										 <tbody>
										 <tr
										  >
											 <td>CNAME</td>
											 <td id='emailToValidate1'></td>
											 <td>u185536.wl037.sendgrid.net</td>
											 <td class="text-center">
												<span id="emailDomainCheck1" class="fas fa-check ml-2" style="color:green;display:none;"></span>
												<span id="emailDomainX1" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
											 </td>
										 </tr>
										 <tr>
											 <td>CNAME</td>
											 <td id='emailToValidate2'></td>
											 <td>s1.domainkey.u185536.wl037.sendgrid.net</td>
											 <td class="text-center">
												<span id="emailDomainCheck2" class="fas fa-check ml-2" style="color:green;display:none;"></span>
												<span id="emailDomainX2" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
											 </td>
										 </tr>
										 <tr>
											 <td>CNAME</td>
											 <td id='emailToValidate3'></td>
											 <td>s2.domainkey.u185536.wl037.sendgrid.net</td>
											 <td class="text-center">
												<span id="emailDomainCheck3" class="fas fa-check ml-2" style="color:green;display:none;"></span>
												<span id="emailDomainX3" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
											 </td>
										 </tr>
										
										 </tbody>
									 </table>
									 </div>
									<!--<div class="row pb-3" style="margin-top:-15px;">
										<div class="col-sm-8 offset-3">
											<span class="small"><span id="emailPrefix">mybrand@stemx.com</span>
											<span id="emailDomainCheck" class="fas fa-check ml-2" style="color:green;display:none;"></span>
											<span id="emailDomainX" class="fas fa-ban ml-2" style="color:red;display:none;"></span>
										</div>
									</div>
									-->
									<div id="form-whitelabelfromname" class="form-group row">
										<label for="whitelabelfromname" class="col-sm-3 col-form-label">Email From Name</label>
										<div class="col-sm-7">
																							<input type="text" class="form-control" id="whitelabel-fromname" place-holder="My Name" name="whitelabelFromName" data-tooltip="tooltip" data-placement="top" title="Upgrade required" disabled> 
																						 
										</div>
									</div>
									
									
									<!--Email End-->
								</div>
								<!--Whitelabel End-->	
							</div>
							<input name="event-url" id="event-url" type="hidden" />
							<input name="eventAction" id="eventAction" type="hidden" value="new" />
							<!-- <input name="accountUID" id="accountUID" type="hidden" value="yW1yKOOW" /> -->
						</form>
						<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="newEventSave">Save Event</button>
				  </div>