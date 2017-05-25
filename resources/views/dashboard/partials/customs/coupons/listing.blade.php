
<section id="page-categories" class="data-content">

    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
        <h2>
          <span>List of coupons</span>
        </h2>
        <span flex></span>
        <md-button class="md-icon-button" aria-label="Add"
            ng-show="!!shopId"
            ng-click="createCoupon($event)">
          <md-icon md-font-icon="icon-plus"></md-icon>
        </md-button>
      </div>
    </md-toolbar>


    <md-content layout-padding="16" class="transparent-content">
      {{--   <md-content class="box-shadow-content">

            <form name="userForm" layout-gt-xs="column">
            </form>
        </md-content> --}}
        <md-content layout-padding="16" class="box-shadow-content">
            <form name="userForm" layout-gt-xs="row">
                <div class="md-toolbar-tools" flex-gt-xs>
                    <span>All coupon listing</span>
                </div>
                <md-input-container flex-gt-xs>
                    <label>Search</label>
                    <input ng-model="search">
                </md-input-container>
            </form>
        </md-content>
        <!-- exact table from live demo -->
        {{-- <md-toolbar class="md-table-toolbar alternate toolbar-selected-item" ng-show="selected.length" aria-hidden="false">
          <div class="md-toolbar-tools layout-align-space-between-stretch" layout-align="space-between">
            <div class="title"><% selected.length %> items selected</div>
            <div class="buttons" layout-align="end center">
                <md-button class="md-icon-button md-button md-ink-ripple"
                    ng-hide="selected.length > 1"
                    type="button" ng-click="edit($event)" aria-label="edit">
                    <md-icon md-font-icon="icon-pencil" class="md-font material-icons icon-office" aria-hidden="true"></md-icon>
                </md-button>
                <md-button class="md-icon-button md-button md-ink-ripple" type="button" ng-click="delete($event)" aria-label="delete">
                    <md-icon md-font-icon="icon-bin2" class="md-font material-icons icon-office" aria-hidden="true"></md-icon>
                </md-button>
            </div>
          </div>
        </md-toolbar> --}}

        <md-table-container class="box-shadow-content">
          <table md-table md-row-selectf multiple ng-model="selected" md-progress="promise">
            <thead md-head md-order="query.order" md-on-reorder="listing">
              <tr md-row>
                <th md-column md-order-by="nameToLower"><span>Coupon Description Name</span></th>
                <th md-column><span>Discount</span></th>
                <th md-column><span>Shop</span></th>
                <th md-column><span>Start Date</span></th>
                <th md-column><span>End Date</span></th>
                <th md-column>Created at</th>
                <th md-column>
                	Status
                </th>
              </tr>
            </thead>
            <tbody md-body>
              <tr md-row md-select="item" md-select-id="_id" ng-click="viewDetail(item)" md-auto-select ng-repeat="item in listing">
                <td md-cell><% item.description %></td>
                <td md-cell><% item.amount %>%</td>
                <td md-cell><% item.directory.directory_name %></td>
                <td md-cell><% formatUtcDate(item.start_date_at) %></td>
                <td md-cell><% formatUtcDate(item.end_date_at) %></td>
                <td md-cell><% formatUtcDate(item.created_at) %></td>
                <td md-cell>
                    <label class="label label-info" ng-show="item.status == 'published'">Published</label>
                    <label class="label label-info" ng-show="item.status !== 'published'">Pending</label>
                </td>
              </tr>
              <tr md-row ng-show="!listing.length">
                <td md-cell colspan="7">There is no coupon data</td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
       
        <md-content layout-padding="16"
            ng-show="pagination.total.length"
            class="box-shadow-content" style="margin-top: 15px;">
            <md-table-pagination md-limit="pagination.limit" md-limit-options="[5, 10, 15]" md-page="pagination.page" md-total="<% pagination.count %>" md-on-paginate="loadData()" md-page-select></md-table-pagination>
        </md-content>
    </md-content>
</section>
