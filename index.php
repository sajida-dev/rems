<?php require_once("components/header.php");
if ($conMessage):
  require_once "backend/about_section_counter.php";
  $limitHomePage = true;
  require_once "backend/select_properties.php";
  require_once "backend/select_agents.php";
  require_once "backend/search_filter.php";
endif;
// require_once "components/notification.php";

?>
<div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text justify-content-center align-items-center">
      <div class="col-lg-8 col-md-6 ftco-animate d-flex align-items-end">
        <div class="text text-center">
          <h1 class="mb-4">The Simplest <br>Way to Find Property</h1>
          <p style="font-size: 18px;">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts</p>
          <form action="filter-properties.php" method="POST" class="search-location mt-md-5">
            <div class="row justify-content-center">
              <div class="col-lg-10 align-items-end">
                <div class="form-group">
                  <div class="form-field d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search location, price, or area">
                    <button type="submit" class="btn btn-primary ml-2">
                      <span class="ion-ios-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
  <div class="mouse">
    <a href="index.php#" class="mouse-icon">
      <div class="mouse-wheel"><span class="ion-ios-arrow-round-down"></span></div>
    </a>
  </div>
</div>

<section class="ftco-section ftco-no-pb">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">Our Services</span>
        <h2 class="mb-2">The smartest way to buy a home</h2>
      </div>
    </div>
    <div class="row d-flex">
      <div class="col-md-3 d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services d-block text-center">
          <div class="icon d-flex justify-content-center align-items-center"><span class="flaticon-piggy-bank"></span></div>
          <div class="media-body py-md-4">
            <h3>No Downpayment</h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services d-block text-center">
          <div class="icon d-flex justify-content-center align-items-center"><span class="flaticon-wallet"></span></div>
          <div class="media-body py-md-4">
            <h3>All Cash Offer</h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services d-block text-center">
          <div class="icon d-flex justify-content-center align-items-center"><span class="flaticon-file"></span></div>
          <div class="media-body py-md-4">
            <h3>Experts in Your Corner</h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services d-block text-center">
          <div class="icon d-flex justify-content-center align-items-center"><span class="flaticon-locked"></span></div>
          <div class="media-body py-md-4">
            <h3>Lokced in Pricing</h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section goto-here">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">What we offer</span>
        <h2 class="mb-2">Exclusive Offer For You</h2>
      </div>
    </div>
    <div class="row">

      <?php

      foreach ($properties as $property):
      ?>
        <div class="col-md-4">
          <div class="property-wrap ftco-animate">
            <a href="properties-single.php?id=<?php echo $property['id']; ?>" class="img" style="background-image: url(<?php echo "dashboard/" . $property['image_url'] ?>);"></a>
            <div class="text">
              <p class="price"><span class="old-price">$<?php echo number_format($property['old_price']) ?></span><span class="orig-price">$<?php echo number_format($property['rent_price']) ?><small>/mo</small></span></p>
              <ul class="property_list">
                <li>
                  <span class="flaticon-bed"></span>
                  <?php echo $property['bedrooms'] ?>
                </li>
                <li><span class="flaticon-bathtub"></span>
                  <?php echo $property['bathrooms'] ?>
                </li>
                <li><span class="flaticon-floor-plan"></span>
                  <?php echo $property['area'] ?> sqft
                </li>
              </ul>
              <h3><a href="properties-single.php?id=<?php echo $property['id']; ?>">
                  <?php echo htmlspecialchars($property['title']) ?>
                </a>
              </h3>
              <span class="location">
                <?php echo htmlspecialchars($property['location']) ?>
              </span>
              <a href="properties-single.php?id=<?php echo $property['id']; ?>" class="d-flex align-items-center justify-content-center btn-custom">
                <span class="ion-ios-link"></span>
              </a>
            </div>
          </div>
        </div>
      <?php
      endforeach;

      ?>
    </div>
    <!-- <div class="row">
      <div class="col-md-4">
        <div class="property-wrap ftco-animate">
          <a href="index.php#" class="img" style="background-image: url(images/work-1.jpg);"></a>
          <div class="text">
            <p class="price"><span class="old-price">800,000</span><span class="orig-price">$3,050<small>/mo</small></span></p>
            <ul class="property_list">
              <li><span class="flaticon-bed"></span>3</li>
              <li><span class="flaticon-bathtub"></span>2</li>
              <li><span class="flaticon-floor-plan"></span>1,878 sqft</li>
            </ul>
            <h3><a href="index.php#">The Blue Sky Home</a></h3>
            <span class="location">Oakland</span>
            <a href="index.php#" class="d-flex align-items-center justify-content-center btn-custom">
              <span class="ion-ios-link"></span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="property-wrap ftco-animate">
          <a href="index.php#" class="img" style="background-image: url(images/work-2.jpg);"></a>
          <div class="text">
            <p class="price"><span class="old-price">800,000</span><span class="orig-price">$3,050<small>/mo</small></span></p>
            <ul class="property_list">
              <li><span class="flaticon-bed"></span>3</li>
              <li><span class="flaticon-bathtub"></span>2</li>
              <li><span class="flaticon-floor-plan"></span>1,878 sqft</li>
            </ul>
            <h3><a href="index.php#">The Blue Sky Home</a></h3>
            <span class="location">Oakland</span>
            <a href="index.php#" class="d-flex align-items-center justify-content-center btn-custom">
              <span class="ion-ios-link"></span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="property-wrap ftco-animate">
          <a href="index.php#" class="img" style="background-image: url(images/work-3.jpg);"></a>
          <div class="text">
            <p class="price"><span class="old-price">800,000</span><span class="orig-price">$3,050<small>/mo</small></span></p>
            <ul class="property_list">
              <li><span class="flaticon-bed"></span>3</li>
              <li><span class="flaticon-bathtub"></span>2</li>
              <li><span class="flaticon-floor-plan"></span>1,878 sqft</li>
            </ul>
            <h3><a href="index.php#">The Blue Sky Home</a></h3>
            <span class="location">Oakland</span>
            <a href="index.php#" class="d-flex align-items-center justify-content-center btn-custom">
              <span class="ion-ios-link"></span>
            </a>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</section>

<section class="ftco-section ftco-degree-bg services-section img mx-md-5" style="background-image: url(images/bg_2.jpg);">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-start mb-5">
      <div class="col-md-6 text-center heading-section heading-section-white ftco-animate">
        <span class="subheading">Work flow</span>
        <h2 class="mb-3">How it works</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services services-2">
              <div class="media-body py-md-4 text-center">
                <div class="icon mb-3 d-flex align-items-center justify-content-center"><span>01</span></div>
                <h3>Evaluate Property</h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services services-2">
              <div class="media-body py-md-4 text-center">
                <div class="icon mb-3 d-flex align-items-center justify-content-center"><span>02</span></div>
                <h3>Meet Your Agent</h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services services-2">
              <div class="media-body py-md-4 text-center">
                <div class="icon mb-3 d-flex align-items-center justify-content-center"><span>03</span></div>
                <h3>Close the Deal</h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services services-2">
              <div class="media-body py-md-4 text-center">
                <div class="icon mb-3 d-flex align-items-center justify-content-center"><span>04</span></div>
                <h3>Have Your Property</h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-no-pb">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/about.jpg);">
      </div>
      <div class="col-md-6 wrap-about py-md-5 ftco-animate">
        <div class="heading-section p-md-5">
          <h2 class="mb-4">We Put People First.</h2>

          <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
          <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-counter img" id="section-counter">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">

      </div>
      <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
        <div class="block-18 py-4 mb-4">
          <div class="text text-border d-flex align-items-center">
            <strong class="number" data-number="<?php echo $total_properties; ?>">0</strong>
            <span>Total <br>Properties</span>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
        <div class="block-18 py-4 mb-4">
          <div class="text text-border d-flex align-items-center">
            <strong class="number" data-number="<?php echo $average_house; ?>">0</strong>
            <span>Average <br>House</span>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">

      </div>
    </div>
  </div>
</section>

<section class="ftco-section testimony-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <span class="subheading">Testimonial</span>
        <h2 class="mb-3">Happy Clients</h2>
      </div>
    </div>
    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel ftco-owl">
          <div class="item">
            <div class="testimony-wrap py-4">
              <div class="text">
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                  <div class="pl-3">
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap py-4">
              <div class="text">
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                  <div class="pl-3">
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap py-4">
              <div class="text">
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
                  <div class="pl-3">
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap py-4">
              <div class="text">
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                  <div class="pl-3">
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimony-wrap py-4">
              <div class="text">
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                  <div class="pl-3">
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($message): ?>
  <section class="ftco-section ftco-agent ftco-no-pt">
    <div class="container">
      <div class="row justify-content-center pb-5">
        <div class="col-md-12 heading-section text-center ftco-animate">
          <span class="subheading">Agents</span>
          <h2 class="mb-4">Our Agents</h2>
        </div>
      </div>

      <div class="row">
        <?php foreach ($agents as $agent): ?>
          <div class="col-md-3">
            <div class="agent">
              <div class="img">
                <img src="<?php echo !empty($agent['profile_pic']) ? "dashboard/" . $agent['profile_pic'] : 'images/default-agent.jpg'; ?>" class="img-fluid" alt="Agent Image">
              </div>
              <div class="desc">
                <h3>
                  <a href="single-agent.php?agent_id=<?php echo $agent['id']; ?>">
                    <?php echo htmlspecialchars($agent['name']); ?>
                  </a>
                </h3>
                <p class="h-info">
                  <span class="location">Listing</span>
                  <span class="details">&mdash; <?php echo $agent['property_count']; ?> Properties</span>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
<?php include_once "components/footer.php" ?>