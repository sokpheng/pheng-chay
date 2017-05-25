<section id="page-posts">
    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
       {{--  <md-button class="md-icon-button" aria-label="Settings">
          <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
        </md-button> --}}
        <h2>
          <b><% titleName || 'My Posts' %></b>
        </h2>
        <span flex></span>
        <md-button class="md-icon-button" aria-label="Add"
            ng-show="showShowAction"
            ng-click="action()">
          <md-icon md-font-icon="icon-plus" fstyle="color: greenyellow;"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    {{-- <h3 class="md-headline text-center form-create-header">My posts</h3> --}}
    <md-content layout-padding="16" class="transparent-content">
        <md-content layout-padding="16" class="box-shadow-content">
            <form name="userForm">
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search">
                </md-input-container>
            </form>
            <div class="suggestion-filter" ng-hide="hideFilter">
                <p class="helper"><i>You may want to find these type of posts</i>:</p>
                 <md-radio-group ng-model="data.filter" class="md-primary border-content">
                    <md-radio-button value="">None</md-radio-button>
                    <md-radio-button value="industry">Industry</md-radio-button><!-- 
                    <md-radio-button value="about-us">About Us</md-radio-button>
                    <md-radio-button value="do-you-know">Do you know?</md-radio-button>
                    <md-radio-button value="do-you-know-detail">Do you know?'s Detail</md-radio-button>
                    <md-radio-button value="operations">Operations</md-radio-button>
                    <md-radio-button value="objective">Objective</md-radio-button>
                    <md-radio-button value="partner">Partners</md-radio-button>
                    <md-radio-button value="contact">Contact</md-radio-button> -->
                </md-radio-group>
            </div>
        </md-content>

        <md-list class="box-shadow-content" style="margin-top: 15px">

            <md-list-item class="md-3-line">
                <div class="md-list-item-text">
                    <div layout="row">
                        <div flex="7"  class="head">
                            No
                        </div>
                        <div flex="20"  class="head">
                            Title
                        </div>
                        <div flex="25"  class="head">
                            Description
                        </div>
                        <div flex="12" class="head">Locale</div>
                        <div flex="12" class="head">Type</div>
                        <div flex="12" class="head">Category</div>
                        <div flex="12" class="head">
                            Edited
                        </div>
                    </div>
                </div>        
            </md-list-item>
        </md-list>
        <md-list class="box-shadow-content" style="margin-top: 15px">
            
            <md-list-item class="md-3-line" 
                ng-if="!posts.length">
                <div class="md-list-item-text">
                    <h4 class="text-center">
                        There is no listing yet! Please, add one or more from the left menu
                    </h4>
                </div>
            </md-list-item>

            <md-list-item class="md-3-line hoverable" 
                ng-repeat="(i, item) in posts | filter: search | orderBy:'-created_at' | startFrom: pagination.offset * pagination.limit | limitTo : pagination.limit ">
                <div class="md-list-item-text" ng-click="edit(item, $event)">
                    <div layout="row">
                        <div flex="7" class="col">
                            <% pagination.offset * pagination.limit  + $index + 1 %>
                        </div>
                        <div flex="20" class="col">
                            <% item.title %>

                            {{-- <h4 ng-if="!item.description && item.customs">
                                <span ng-repeat="custom in item.customs"><% custom.model %> </span>
                            </h4> --}}
                        </div>
                        <div flex="25" class="col"
                            style="word-break: break-all;
                                white-space: inherit;
                                word-wrap: break-word;">
                            <span ng-bind="(item.description || '' | limitTo: 160) + (item.description.length > 160 ? '...' : '')"></span>
                        </div>
                        <div flex="12" class="col"><span ng-show="item.has_kh_locale">KH</span></div>
                        <div flex="12" class="col"><% item.type.display_name %></div>
                        <div flex="12" class="col"><% item.category.display_name %></div>
                        <div flex="12" class="col">
                            <span>
                                <% fromDate(item.updated_at) %>
                            </span>
                        </div>
                    </div>

                   {{--  <md-menu class="md-menu-list-item">
                        <md-button aria-label="Open phone interactions menu" class="md-icon-button" ng-click="$mdOpenMenu()">
                            <md-icon md-menu-origin md-font-icon="icon-wrench"></md-icon>
                        </md-button>
                        <md-menu-content width="4">
                            <md-menu-item>
                              <md-button ng-click="edit(item, $event)">
                                <md-icon md-font-icon="icon-quill" md-menu-align-target></md-icon>
                                Edit
                              </md-button>
                            </md-menu-item>
                            <md-menu-item>
                              <md-button ng-click="editLocale(item, $event)">
                                <md-icon md-font-icon="icon-notification" md-menu-align-target></md-icon>
                                Edit Locale
                              </md-button>
                            </md-menu-item>
                        </md-menu-content>
                    </md-menu> --}}
                </div>
            </md-list-item>
        </md-list>
        <md-content layout-padding="16" 
            ng-show="pagination.total.length"
            class="box-shadow-content" style="margin-top: 15px;">            
            <ul class="md-pagination">
                <li ng-repeat="offset in pagination.total">
                    <md-button class="md-raised" 
                        ng-class="{'md-primary': offset - 1 == pagination.offset}"
                        ng-click="changeOffset(offset - 1)"><% offset %></md-button>
            </ul>
        </md-content>
    </md-content>

</section>