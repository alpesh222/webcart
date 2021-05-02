<!-- ============================================== MEGA MENU SUBCATEGORIES SIDEBAR============================================== -->
<ul class="dropdown-menu mega-menu">
    <li class="yamm-content">
        <div class="row">
            @foreach($child_categories as $child)
                @if($child->is_active)
                    <div class="col-sm-12 col-md-3">
                        <h2 class="title"><a class="pl-0" href="{{route('front.category.show', [$child->slug])}}">{{$child->name}}</a></h2>
                        <ul class="links list-unstyled sub-cat-container">
                            @if($child->categories()->where('show_in_menu', true)->count())
                                @foreach($child->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get() as $child_sub_category)
                                    @if($child_sub_category->is_active)
                                        <li>
                                            <a class="pl-0" href="{{route('front.category.show', [$child_sub_category->slug])}}">{{$child_sub_category->name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
            @endforeach
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </li>
    <!-- /.yamm-content -->
</ul>


<!-- /.sidebar -->
<!-- ============================================== MEGA MENU SUBCATEGORIES SIDEBAR : END ============================================== -->