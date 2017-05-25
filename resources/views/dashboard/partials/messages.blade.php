<section id="page-messages" class="data-content">

    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
        <h2>
          <span>Messages</span>
        </h2>
        <span flex></span>
      </div>
    </md-toolbar>

    <md-content layout-padding="16" class="transparent-content">
        <md-content layout-padding="16" class="box-shadow-content">
            <form name="userForm">
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search">
                </md-input-container>
            </form>
        </md-content>

        <md-list class="box-shadow-content" style="margin-top: 15px">
            <md-list-item class="md-3-line">
                <div class="md-list-item-text">
                    <div layout="row">
                        <div flex="7"  class="head">
                            No
                        </div>
                        <div flex="20"  class="head">
                            Sender
                        </div>
                        <div flex="25"  class="head">
                            Message
                        </div>
                        <div flex="12" class="head">Phone</div>
                        <div flex="12" class="head">Email</div>
                        <div flex="12" class="head">Status</div>
                        <div flex="12" class="head">
                            Created
                        </div>
                    </div>
                </div>        
            </md-list-item>
        </md-list>

        <md-list class="box-shadow-content" style="margin-top: 15px">
            
            <md-list-item class="md-3-line" 
                ng-if="!listing.length">
                <div class="md-list-item-text">
                    <h4 class="text-center">
                        There is no new incoming messages
                    </h4>
                </div>
            </md-list-item>

            <md-list-item class="md-3-line hoverable" 
                ng-repeat="(i, item) in listing | filter: search | orderBy:'-created_at' | startFrom: pagination.offset * pagination.limit | limitTo : pagination.limit ">
                <div class="md-list-item-text " ng-click="view(item, $event)">
                    <div layout="row" style="font-weight: <% item.is_read ? 'normal' : 'bold' %>">
                        <div flex="7" class="col">
                            <% pagination.offset * pagination.limit  + $index + 1 %>
                        </div>
                        <div flex="20" class="col">
                            <% item.sender_name %>

                            {{-- <h4 ng-if="!item.description && item.customs">
                                <span ng-repeat="custom in item.customs"><% custom.model %> </span>
                            </h4> --}}
                        </div>
                        <div flex="25" class="col">
                            <span ng-bind-html="(item.description | limitTo: 1000) + (item.description.length > 1000 ? '...' : '')"></span>
                        </div>
                        <div flex="12" class="col"><% item.sender_phone %></div>
                        <div flex="12" class="col"><% item.sender_email %></div>
                        <div flex="12" class="col"><% item.is_read ? 'Read' : 'New' %></div>
                        <div flex="12" class="col">
                            <span>
                                <% fromDate(item.created_at) %>
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