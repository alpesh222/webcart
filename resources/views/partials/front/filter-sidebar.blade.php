<style>
  .filers-list { max-height:150px; width:100%; }
  .filers-list { overflow:hidden; overflow-y:scroll; }
  .filters > li > div { font-size: 15px; cursor: pointer; }
  .filters > li > div:hover { background-color: #eee; }
  .filters-toggle:after {
    font-family: 'Glyphicons Halflings';
    content: "\e114";
    float: right;
    color: grey;
  }
  .filters-toggle.collapsed:after {
      content: "\e080";
  }
  ::-webkit-scrollbar {
    background: #eee;
    border-radius: 4px;
    height: 8px;
    width: 8px;
  }
  ::-webkit-scrollbar-thumb {
    background: #999;
    border-radius: 4px;
  }
  .filters {
    padding-right: 25px;
    padding-left: 25px;
    border: 2px solid #eee;
    border-radius: 5px;
  }
  .filters, .filters ul {
    list-style: none;
  }
  .filters ul {
    padding: 0;
  }
  .filters-title {
    font-size: 18px;
    font-weight: 500;
    color: #999;
    background-color: #eee;
    margin-bottom: 10px;
  }
  .ui-slider .ui-slider-range {
    z-index: 0;
  }
</style>
<div class="filters-title text-center">@lang('Filters')</div>
<ul class="filters">
  <li>
    <p>
      <label for="amount"><strong>@lang('Price range')</strong></label>
      <input type="text" id="amount" readonly style="border:0; color:#068; font-weight:bold;">
    </p>
    <div id="slider-range"></div>
    <hr>
  </li>
  @if(isset($category))
  <li>
    <div class="filters-toggle collapsed" data-toggle="collapse" data-target="#filers-list-brands"><strong>@lang('Brands')</strong></div>
    <ul class="filers-list collapse" id="filers-list-brands">
      @foreach($category->all_products()->unique('brand_id') as $product)
        @if($product->brand)
        <li>
          <div class="checkbox">
            <label><input class="filter_products_brands" data-value='{"id":"{{$product->brand->id}}"}' type="checkbox">{{$product->brand->name}}</label>
          </div>
        </li>
        @endif
      @endforeach
    </ul>
    <hr>
  </li>
  @elseif(isset($brand))
  <li>
    <div class="filters-toggle collapsed" data-toggle="collapse" data-target="#filers-list-categories"><strong>@lang('Categories')</strong></div>
    <ul class="filers-list collapse" id="filers-list-categories">
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
    <hr>
  </li>
  @else
  <li>
    <div class="filters-toggle collapsed" data-toggle="collapse" data-target="#filers-list-categories"><strong>@lang('Categories')</strong></div>
    <ul class="filers-list collapse" id="filers-list-categories">
      <?php $dataCategories = []; ?>
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
    <hr>
  </li>
  <li>
    <div class="filters-toggle collapsed" data-toggle="collapse" data-target="#filers-list-brands"><strong>@lang('Brands')</strong></div>
    <ul class="filers-list collapse" id="filers-list-brands">
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
    <hr>
  </li>
  @endif
  @if(isset($category))
  @foreach($category->specificationTypes as $specificationType)
  <li>
    <?php $data = []; ?>
    <div class="filters-toggle collapsed" data-toggle="collapse" data-target="#filers-list-{{str_slug($specificationType->name)}}"><strong>{{$specificationType->name}}</strong></div>
    <ul class="filers-list collapse" id="filers-list-{{str_slug($specificationType->name)}}">
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
    <hr>
  </li>
  @endforeach
  @endif
</ul>
