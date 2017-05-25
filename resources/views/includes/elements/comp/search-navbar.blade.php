{{ Form::open(array(
   'action' => 'RestaurantController@searchPostText',
   'name' => 'home_search',
   'accept-charsetme' => 'utf-8',
   'method' => 'POST',
   'class' => 'flex-1 '. $cls,
   'ng-class'  => '{"is_show": is_show_full_width_search}'
   )) }}
   <div class="flat-control-full-radius flex-1">
      <div class="form-group no-marg d-inline-block">
         <input type="text" class="form-control search-on-nav {{ isset($onMapSearch) ? 'size-lg' : '' }}" name="text_search" id="mega_search" aria-describedby1="emailHelp" placeholder="{{ trans('content.navbar.i_looking_for') }} ..." value="{{
            $search_text or ''
            }}">

         @if(isset($onMapSearch))

{{--             <div class="d-inline-block filter-option hidden-lg-down" style="margin-left: 10px;">
               <a href="#map_advance_filter" class="popupAdvanceFilter float-xs-right" title="{{ trans('content.general.advance_filter') }}"><span class="icon-tune"></span></a>
            </div> --}}
            
         @endif
         
         <button type="submit" class="btn-search" href="{{ URL::to('/search/top-restaurant') }}" title=""><span class="icon-search"></span></button>


      </div>

   </div>

   @if(isset($is_full_width_search))

      <button class="bt-clear-style bt-close-search" type="button" ng-click="is_show_full_width_search=!is_show_full_width_search" ><span class="icon-close"></span></button>

   @endif

{{ Form::close() }} 