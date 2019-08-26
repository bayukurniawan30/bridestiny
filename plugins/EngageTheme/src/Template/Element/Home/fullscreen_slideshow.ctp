<section class="fullscreen-slideshowS relative mt-0">
    <div class="fullscreen-slideshow">
        <div class="item">
            <?= $this->Html->image('slideshow/s3.jpg', ['alt' => '', 'class' => '']); ?>
        </div>
        
        <div class="item">
            <?= $this->Html->image('slideshow/s5.jpg', ['alt' => '', 'class' => '']); ?>
            <!-- <div class="info"> -->
                <!-- <h1 class="text-white">Our Love Journey</h1> -->
                <!-- <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</h5> -->
            <!-- </div> -->
        </div>
    </div>
    <div class="bridme-search">
        <div class="underlay"></div>
        <div class="content">
            <form class="uk-form">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-sm-4 pr-0 pl-0">
                    <select class="select-vendor rounded-0  w-100">
                        <option value="">Select Vendor</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-4 pr-0 pl-0">
                    <div class="input-group">
                        <input id="datepicker-brideme" placeholder="Select date" type="text" class="form-control rounded-0 " value="">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-4 pr-0 pl-0">
                    <button type="submit" class="btn btn-brideme-border fade-hover-color" style="border:none"> Search </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>