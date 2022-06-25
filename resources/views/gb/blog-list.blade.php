<?php $page="blog-list";?>
@extends('layout.mainlayout')
@section('content')		
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Blog</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Blog List</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
             
					<div class="row">
					
						<div class="col-lg-8 col-md-12">

							<!-- Blog Post -->
							<div class="blog">
								<div class="blog-image">
									<a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-01.jpg" alt="Post Image"></a>
								</div>
								<h3 class="blog-title"><a href="blog-details">Sed ut perspiciatis unde omnis iste natus error sit voluptatem</a></h3>
								<div class="blog-info clearfix">
									<div class="post-left">
										<ul>
											<li>
												<div class="post-author">
													<a href="profile"><img src="assets/img/user/user.jpg" alt="Post Author"> <span>Ruby Perrin</span></a>
												</div>
											</li>
											<li><i class="far fa-clock"></i>4 Dec 2019</li>
											<li><i class="far fa-comments"></i>12 Comments</li>
											<li><i class="fa fa-tags"></i>HTML</li>
										</ul>
									</div>
								</div>
								<div class="blog-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco sit laboris ullamco laborisut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a href="blog-details" class="read-more">Read More</a>
								</div>
							</div>
							<!-- /Blog Post -->

							<!-- Blog Post -->
							<div class="blog">
								<div class="blog-image">
									<a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-02.jpg" alt=""></a>
								</div>
								<h3 class="blog-title"><a href="blog-details">1914 translation by H. Rackham</a></h3>
								<div class="blog-info clearfix">
									<div class="post-left">
										<ul>
											<li>
												<div class="post-author">
													<a href="profile"><img src="assets/img/user/user1.jpg" alt="Post Author"> <span>Darren Elder</span></a>
												</div>
											</li>
											<li><i class="far fa-clock"></i>3 Dec 2019</li>
											<li><i class="far fa-comments"></i>7 Comments</li>
											<li><i class="fa fa-tags"></i>Java Script</li>
										</ul>
									</div>
								</div>
								<div class="blog-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco sit laboris ullamco laborisut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a href="blog-details" class="read-more">Read More</a>
								</div>
							</div>
							<!-- /Blog Post -->

							<!-- Blog Post -->
							<div class="blog">
								<div class="blog-image">
									<div class="video">
										<iframe width="940" src="https://www.youtube.com/embed/ZMty6R0Bn0I" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</div>
								</div>
								<h3 class="blog-title"><a href="blog-details">The standard Lorem Ipsum passage, used since the</a></h3>
								<div class="blog-info clearfix">
									<div class="post-left">
										<ul>
											<li>
												<div class="post-author">
													<a href="profile"><img src="assets/img/user/user2.jpg" alt="Post Author"> <span>Deborah Angel</span></a>
												</div>
											</li>
											<li><i class="far fa-clock"></i>3 Dec 2019</li>
											<li><i class="far fa-comments"></i>2 Comments</li>
											<li><i class="fa fa-tags"></i>C++</li>
										</ul>
									</div>
								</div>
								<div class="blog-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco sit laboris ullamco laborisut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a href="blog-details" class="read-more">Read More</a>
								</div>
							</div>
							<!-- /Blog Post -->

							<!-- Blog Post -->
							<div class="blog">
								<div class="blog-image">
									<div class="video">
										<iframe width="940" src="https://www.youtube.com/embed/svmGQhQLuBQ" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</div>
								</div>
								<h3 class="blog-title"><a href="blog-details">Section 1.10.32 of "de Finibus Bonorum et Malorum</a></h3>
								<div class="blog-info clearfix">
									<div class="post-left">
										<ul>
											<li>
												<div class="post-author">
													<a href="profile"><img src="assets/img/user/user3.jpg" alt="Post Author"> <span>Sofia Brient</span></a>
												</div>
											</li>
											<li><i class="far fa-clock"></i>2 Dec 2019</li>
											<li><i class="far fa-comments"></i>41 Comments</li>
											<li><i class="fa fa-tags"></i>Css</li>
										</ul>
									</div>
								</div>
								<div class="blog-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco sit laboris ullamco laborisut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a href="blog-details" class="read-more">Read More</a>
								</div>
							</div>
							<!-- /Blog Post -->

							<!-- Blog Pagination -->
							<div class="row">
								<div class="col-md-12">
									<div class="blog-pagination">
										<nav>
											<ul class="pagination justify-content-center">
												<li class="page-item disabled">
													<a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-double-left"></i></a>
												</li>
												<li class="page-item">
													<a class="page-link" href="#">1</a>
												</li>
												<li class="page-item active">
													<a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
												</li>
												<li class="page-item">
													<a class="page-link" href="#">3</a>
												</li>
												<li class="page-item">
													<a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
												</li>
											</ul>
										</nav>
									</div>
								</div>
							</div>
							<!-- /Blog Pagination -->
							
						</div>
						
						<!-- Blog Sidebar -->
						<div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

							<!-- Search -->
							<div class="card search-widget">
								<div class="card-body">
									<form class="search-form">
										<div class="input-group">
											<input type="text" placeholder="Search..." class="form-control">
											<div class="input-group-append">
												<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- /Search -->

							<!-- Latest Posts -->
							<div class="card post-widget">
								<div class="card-header">
									<h4 class="card-title">Latest Posts</h4>
								</div>
								<div class="card-body">
									<ul class="latest-posts">
										<li>
											<div class="post-thumb">
												<a href="blog-details">
													<img class="img-fluid" src="assets/img/blog/blog-thumb-01.jpg" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details">Lorem Ipsum is simply dummy text of the printing</a>
												</h4>
												<p>4 Dec 2019</p>
											</div>
										</li>
										<li>
											<div class="post-thumb">
												<a href="blog-details">
													<img class="img-fluid" src="assets/img/blog/blog-thumb-02.jpg" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details">It is a long established fact that a reader will be</a>
												</h4>
												<p>3 Dec 2019</p>
											</div>
										</li>
										<li>
											<div class="post-thumb">
												<a href="blog-details">
													<img class="img-fluid" src="assets/img/blog/blog-thumb-03.jpg" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details">here are many variations of passages of Lorem Ipsum</a>
												</h4>
												<p>3 Dec 2019</p>
											</div>
										</li>
										<li>
											<div class="post-thumb">
												<a href="blog-details">
													<img class="img-fluid" src="assets/img/blog/blog-thumb-04.jpg" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details">The standard chunk of Lorem Ipsum used since the</a>
												</h4>
												<p>2 Dec 2019</p>
											</div>
										</li>
										<li>
											<div class="post-thumb">
												<a href="blog-details">
													<img class="img-fluid" src="assets/img/blog/blog-thumb-05.jpg" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details">generate Lorem Ipsum which looks reasonable</a>
												</h4>
												<p>1 Dec 2019</p>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<!-- /Latest Posts -->

							<!-- Categories -->
							<div class="card category-widget">
								<div class="card-header">
									<h4 class="card-title">Blog Categories</h4>
								</div>
								<div class="card-body">
									<ul class="categories">
										<li><a href="#">HTML <span>(62)</span></a></li>
										<li><a href="#">Css <span>(27)</span></a></li>
										<li><a href="#">Java Script <span>(41)</span></a></li>
										<li><a href="#">Photoshop <span>(16)</span></a></li>
										<li><a href="#">Wordpress <span>(55)</span></a></li>
										<li><a href="#">VB <span>(07)</span></a></li>
									</ul>
								</div>
							</div>
							<!-- /Categories -->

							<!-- Tags -->
							<div class="card tags-widget">
								<div class="card-header">
									<h4 class="card-title">Tags</h4>
								</div>
								<div class="card-body">
									<ul class="tags">
										<li><a href="#" class="tag">HTML</a></li>
										<li><a href="#" class="tag">Css</a></li>
										<li><a href="#" class="tag">Java Script</a></li>
										<li><a href="#" class="tag">Jquery</a></li>
										<li><a href="#" class="tag">Wordpress</a></li>
										<li><a href="#" class="tag">Php</a></li>
										<li><a href="#" class="tag">Angular js</a></li>
										<li><a href="#" class="tag">React js</a></li>
										<li><a href="#" class="tag">Vue js</a></li>
										<li><a href="#" class="tag">Photoshop</a></li>
										<li><a href="#" class="tag">Ajax</a></li>
										<li><a href="#" class="tag">Json</a></li>
										<li><a href="#" class="tag">C</a></li>
										<li><a href="#" class="tag">C++</a></li>
										<li><a href="#" class="tag">Vb</a></li>
										<li><a href="#" class="tag">Vb.net</a></li>
										<li><a href="#" class="tag">Asp.net</a></li>
									</ul>
								</div>
							</div>
							<!-- /Tags -->
							
						</div>
						<!-- /Blog Sidebar -->
						
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
@endsection