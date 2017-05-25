<section id="page-categories" class="data-content">

    <md-toolbar class="md-theme-indigo md-default-theme">
        <div class="md-toolbar-tools">
            <h2>
                <span>List of booking </span>
            </h2>
            <span flex></span>
            <md-button class="md-icon-button" aria-label="Add" ng-click="createDimension($event)">
                <md-icon md-font-icon="icon-plus"></md-icon>
            </md-button>
        </div>
    </md-toolbar>


    <md-content layout-padding="16" class="transparent-content">


        <md-content layout-padding="16" class="box-shadow-content">
            <form name="userForm" layout-gt-xs="column">
                <div layout-gt-xs="row" flex-gt-xs>


                    <div class="md-toolbar-tools" flex-gt-xs>
                        <span>List of booking</span>
                    </div>
                    <!--<md-input-container flex-gt-xs>
                        <label>Search</label>
                        <input ng-model="search.query">
                    </md-input-container>-->
                </div>


                <div layout-gt-xs="row" flex-gt-xs>
                    <!--<div class="md-toolbar-tools" flex-gt-xs>
                        <span flex="40">Brand: </span>
                        <md-select ng-model="search.brand" ng-model-options="{trackBy: '$value.id'}" placeholder="Select Brand" flex="60">
                            <md-option value="">Default</md-option>
                            <md-option ng-value="brand" ng-repeat="brand in brands">
                                <%brand.name %>
                            </md-option>
                        </md-select>
                    </div>

                    <div class="md-toolbar-tools" flex-gt-xs>
                        <span flex="40">Category: </span>
                        <md-select ng-model="search.category" ng-model-options="{trackBy: '$value.id'}" placeholder="Select Category" flex="60" ng-change="categoryChange(search.category)">
                            <md-option value="">Default</md-option>
                            <md-option ng-value="category" ng-repeat="category in categories">
                                <%category.name %>
                            </md-option>
                        </md-select>
                    </div>-->
                    <md-input-container flex-gt-xs ng-if1="data.is_new">
                        <md-icon md-font-icon="icon-calendar" class="icon-contact" style="display:inline-block;"></md-icon>

                        <input mdc-datetime-picker date="true" time="false" type="text" id="time" short-time="true" placeholder="Set new shop until" ng-model="data.created_at_from">
                    </md-input-container>
                    <md-input-container flex-gt-xs ng-if1="data.is_new">
                        <md-icon md-font-icon="icon-calendar" class="icon-contact" style="display:inline-block;"></md-icon>

                        <input mdc-datetime-picker date="true" time="false" type="text" id="time" short-time="true" placeholder="Set new shop until" ng-model="data.created_at_to">
                    </md-input-container>

                    <div class="md-toolbar-tools" flex-gt-xs>
                        <span flex="40">Status: </span>
                        <md-select ng-model="search.status" ng-model-options1="{trackBy: '$value.id'}" placeholder="Select Status" flex="60" ng-change="changeStatus()">
                            <md-option value="">Default</md-option>
                            <md-option value="approved">Approve</md-option>
                            <md-option value="canceled">Cancel</md-option>
                        </md-select>
                    </div>

                </div>

            </form>
        </md-content>
        <!-- exact table from live demo -->
        <md-toolbar class="md-table-toolbar alternate toolbar-selected-item" ng-show="selected.length == 1" aria-hidden="false">
            <div class="md-toolbar-tools layout-align-space-between-stretch" layout-align="space-between">
                <div class="title">
                    <% selected.length %> items selected</div>
                <div class="buttons" layout-align="end center">
                    <md-button class="md-icon-button md-button md-ink-ripple" style="width: 100px" type="button" ng-click="setApproveItems(selected,$event)" aria-label="Approved">
                        <md-icon md-font-icon="icon-blocked" class="md-font material-icons icon-office" style="display: inline-block;" aria-hidden="true"></md-icon>
                        Approved
                    </md-button>
                    <md-button class="md-icon-button md-button md-ink-ripple" type="button" ng-click="setCancelItems(selected,$event)" aria-label="Cancel" style="width: 120px">
                        <md-icon md-font-icon="icon-bin2" class="md-font material-icons icon-loop2" style="display: inline-block;" aria-hidden="true"></md-icon>
                        Cancel
                    </md-button>

                    <md-button class="md-icon-button md-button md-ink-ripple" type="button" ng-click="setActiveItems(selected,$event)" aria-label="Active" style="width: 120px">
                        <md-icon md-font-icon="icon-bin2" class="md-font material-icons icon-loop2" style="display: inline-block;" aria-hidden="true"></md-icon>
                        Active
                    </md-button>
                </div>
            </div>
        </md-toolbar>

        <md-table-container class="box-shadow-content">
            <table md-table md-row-select multiple ng-model="selected" md-progress="promise" class="custom-listing">
                <thead md-head md-order="query.order" md-on-reorder="items">
                    <tr md-row>
                        <!--<th md-column colspan1="2" md-order-by1="nameToLower"><span>Country</span></th>-->
                        <th md-column colspan1="2" md-order-by1="nameToLower"><span>Hotel</span></th>
                        <th md-column colspan1="2" md-order-by1="nameToLower"><span>Email</span></th>
                        <th md-column colspan1="2" md-order-by1="nameToLower"><span>Phone</span></th>
                        <th md-column><span>Checking date</span></th>
                        <th md-column><span>Checkout date</span></th>
                        <th md-column style="width: 50px;">Created at</th>
                        <th md-column><span>Status</span></th>
                    </tr>
                </thead>
                <tbody md-body>
                    <tr md-row md-select="item" md-select-id="_id" fmd-auto-select ng-repeat="item in booking">
                        <!--
                        <td md-cell>
                            <% item.country_name %>
                        </td>-->

                        <td md-cell>
                            <a href="javascript:void(0)" ng-click="view(item, $event)">
                                <% item.room_type.hotel.name %>
                            </a>

                        </td>
                        <td md-cell>
                            <% item.email %>
                        </td>

                        <td md-cell>
                            <% item.phone_number %>
                        </td>
                        <td md-cell>
                            <% formatUtcDate(item.checkin, 'DD/MM/YYYY HH:mm')  %>
                        </td>

                        <td md-cell>
                            <% formatUtcDate(item.checkout, 'DD/MM/YYYY HH:mm') %>
                        </td>
                        <td md-cell>
                            <% formatUtcDate(item.created_at, 'DD/MM/YYYY HH:mm') %>
                        </td>
                        <td md-cell>
                            <span><%item.status%></span> {{-- <span class="lb-warning" ng-show="item.status == 'blocked'">Blocked</span> --}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </md-table-container>

        <!--<md-content layout-padding="16" ng-show="pagination.total_record.length" class="box-shadow-content" style="margin-top: 15px;">
            <md-table-pagination md-limit="pagination.limit" md-limit-options1="[5, 10, 15]" md-page1="pagination.page" md-total="<% pagination.total_record %>" md-on-paginate1="loadData()" md-page-select1></md-table-pagination>
        </md-content>-->

        <md-content layout-padding="16" class="box-shadow-content" style="margin-top: 15px">

            <div class="text-center" layout="row" layout-align="center center">

                <cl-paging flex cl-pages="pagination.total_record" cl-steps="pagination.limit" cl-page-changed="onPageChanged()" cl-align="center center" cl-current-page="pagination.offset"></cl-paging>

            </div>
        </md-content>



    </md-content>
</section>