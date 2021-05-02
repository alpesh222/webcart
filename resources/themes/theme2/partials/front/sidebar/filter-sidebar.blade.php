<!-- ================================== SIDEBAR FILTER : STARTS ================================== -->
<div class="sidebar-module-container mb-20">
  <div class="sidebar-filter">
    <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
    <div class="sidebar-widget wow fadeInUp">
      <h3 class="section-title">@lang('Filters')</h3>
{{--      <div class="widget-header">--}}
{{--        <h4 class="widget-title">Category</h4>--}}
{{--      </div>--}}
      <div class="sidebar-widget-body">
        <div class="accordion">
          @if(isset($category))
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#filers-list-brands" data-toggle="collapse" class="accordion-toggle collapsed"> @lang('Brands') </a> </div>
              <!-- /.accordion-heading -->
              <div class="accordion-body collapse" id="filers-list-brands" style="height: 0px;">
                <div class="accordion-inner">
                  <ul>
                    @foreach($category->all_products()->unique('brand_id') as $product)
                      @if($product->brand)
                        <li><div class="checkbox">
                            <label>
                              <input class="filter_products_brands" data-value='{"id":"{{$product->brand->id}}"}' type="checkbox">{{$product->brand->name}}
                            </label>
                          </div></li>
                      @endif
                    @endforeach
                  </ul>
                </div>
                <!-- /.accordion-inner -->
              </div>
              <!-- /.accordion-body -->
            </div>
            <!-- /.accordion-group -->
          @elseif(isset($brand))
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#filers-list-categories" data-toggle="collapse" class="accordion-toggle collapsed"> @lang('Categories') </a> </div>
              <!-- /.accordion-heading -->
              <div class="accordion-body collapse" id="filers-list-categories" style="height: 0px;">
                <div class="accordion-inner">
                  <ul>
                    @foreach($brand->products()->distinct()->get(['category_id']) as $product)
                      @if($product->category)
                        <li>
                          <div class="checkbox">
                            <label><input class="filter_products_categories" data-value='{"id":"{{$product->category->id}}"}' type="checkbox">{{$product->category->name}}</label>
                          </div>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
                <!-- /.accordion-inner -->
              </div>
              <!-- /.accordion-body -->
            </div>
            <!-- /.accordion-group -->
          @else
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#filers-list-categories" data-toggle="collapse" class="accordion-toggle collapsed"> @lang('Categories') </a> </div>
              <!-- /.accordion-heading -->
              <div class="accordion-body collapse" id="filers-list-categories" style="height: 0px;">
                <div class="accordion-inner">
                  <ul>
                    <?php  $dataCategories = []; ?>
                    @foreach($products as $product)
                      @if($product->category)
                        @if(!in_array($product->category->name, $dataCategories))
                          <?php array_push($dataCategories, $product->category->name); ?>
                          <li>
                            <div class="checkbox">
                              <label><input class="filter_products_categories" data-value='{"id":"{{$product->category->id}}"}' type="checkbox">{{$product->category->name}}</label>
                            </div>
                          </li>
                        @endif
                      @endif
                    @endforeach
                  </ul>
                </div>
                <!-- /.accordion-inner -->
              </div>
              <!-- /.accordion-body -->
            </div>
            <!-- /.accordion-group -->

            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#filers-list-brands" data-toggle="collapse" class="accordion-toggle collapsed"> @lang('Brands') </a> </div>
              <!-- /.accordion-heading -->
              <div class="accordion-body collapse" id="filers-list-brands" style="height: 0px;">
                <div class="accordion-inner">
                  <ul>
                    <?php $dataBrands = []; ?>
                    @foreach($products as $product)
                      @if($product->brand)
                        @if(!in_array($product->brand->name, $dataBrands))
                          <?php array_push($dataBrands, $product->brand->name); ?>
                          <li>
                            <div class="checkbox">
                              <label><input class="filter_products_brands" data-value='{"id":"{{$product->brand->id}}"}' type="checkbox">{{$product->brand->name}}</label>
                            </div>
                          </li>
                        @endif
                      @endif
                    @endforeach
                  </ul>
                </div>
                <!-- /.accordion-inner -->
              </div>
              <!-- /.accordion-body -->
            </div>
            <!-- /.accordion-group -->
          @endif

          @if(isset($category))
            @foreach($category->specificationTypes as $specificationType)
              <div class="accordion-group">
                <?php $data = []; ?>
                <div class="accordion-heading"> <a href="#filers-list-{{str_slug($specificationType->name)}}" data-toggle="collapse" class="accordion-toggle collapsed"> {{$specificationType->name}} </a> </div>
                <!-- /.accordion-heading -->
                <div class="accordion-body collapse" id="filers-list-{{str_slug($specificationType->name)}}" style="height: 0px;">
                  <div class="accordion-inner">
                    <ul>
                      @foreach($products as $product)
                        @if($product->specificationTypes->contains($specificationType->id))
                          @foreach($product->specificationTypes as $productSpecificationType)
                            @if($productSpecificationType->id == $specificationType->id)
                              @if(isset($productSpecificationType->pivot->value))
                                <?php $value_unit = $productSpecificationType->pivot->value.''.$productSpecificationType->pivot->unit; ?>
                                @if(!in_array($value_unit, $data))
                                  <?php array_push($data, $value_unit); ?>
                                  <li>
                                    <div class="checkbox">
                                      <label><input class="filter_products" data-value='{"id":"{{$specificationType->id}}","value":"{{$productSpecificationType->pivot->value}}", "unit":"{{$productSpecificationType->pivot->unit}}"}' type="checkbox">{{$productSpecificationType->pivot->value}} {{$productSpecificationType->pivot->unit}}</label>
                                    </div>
                                  </li>
                                @endif
                              @endif
                            @endif
                          @endforeach
                        @endif
                      @endforeach
                    </ul>
                  </div>
                  <!-- /.accordion-inner -->
                </div>
                <!-- /.accordion-body -->
              </div>
              <!-- /.accordion-group -->
            @endforeach
          @endif
        </div>
        <!-- /.accordion -->
      </div>
      <!-- /.sidebar-widget-body -->
    </div>
    <!-- /.sidebar-widget -->
    <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->

    <!-- ============================================== PRICE SILDER============================================== -->
    <div class="sidebar-widget wow fadeInUp">
      <div class="widget-header">
        <h4 class="widget-title">@lang('Price Range')</h4>
      </div>
      <div class="sidebar-widget-body m-t-10">
        <div class="price-range-holder">
          <input type="text" id="amount" readonly style="border:0; color:#666666; font-weight:bold;text-align:center;">
          <div id="slider-range"></div>
{{--          <input type="text" class="price-slider" value="" >--}}
        </div>
        <!-- /.price-range-holder -->
      </div>
    <!-- /.sidebar-widget -->
    <!-- ============================================== PRICE SILDER : END ============================================== -->
  </div>
  <!-- /.sidebar-filter -->
</div>
</div>
<!-- /.sidebar-filter-section -->

<!-- ================================== SIDEBAR FILTER : ENDS ================================== -->
