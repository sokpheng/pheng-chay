<md-dialog aria-label="New Type" id="dialog-new-type">
    <form name="dialogFormType" ng-submit="save($event)">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2> Booking Information </h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content class="dimension-create">
            <div layout-gt-xs="column" style="margin-top: 15px;">
                <md-tabs md-dynamic-height md-border-bottom>

                    {{-- Customer Infos --}}
                    <md-tab label="customer infos">
                        <div style="margin-top: 15px;" layout-gt-xs="column">
                            <md-input-container flex-gt-xs>
                                <label>Last Name </label>
                                <input ng-model="data.last_name" name="name" ng-disabled="true">
                            </md-input-container>
                            <md-input-container flex-gt-xs>
                                <label>First Name </label>
                                <input ng-model="data.first_name" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex-gt-xs>
                                <label>Phone Number </label>
                                <input ng-model="data.phone_number" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex-gt-xs>
                                <label> Email </label>
                                <input ng-model="data.email" name="name" ng-disabled="true">
                            </md-input-container>

                        </div>
                    </md-tab>
                    {{-- Detail Booking --}}
                    <md-tab label="detail">
                        <div style="margin-top: 15px;" layout-gt-xs="column">
                            <!--<md-input-container flex-gt-xs>
                                <label>Display Name</label>
                                <input ng-model="data.display_name" name="display_name" required ng-disabled="noDimensionInfo">
                                <div ng-messages="dialogFormType.display_name.$error" ng-show="dialogFormType.display_name.$dirty && dialogFormType.display_name.$invalid">
                                    <div ng-message="required">Display Name is required</div>
                                </div>
                            </md-input-container>-->

                            <md-input-container flex>
                                <label>Hotel Name</label>
                                <input ng-model="data.room_type.hotel.name" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Roomtype</label>
                                <input ng-model="data.room_type.title" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Checkin Date</label>
                                <input ng-model="data.checkin" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Checkout Date</label>
                                <input ng-model="data.checkout" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Order Date</label>
                                <input ng-model="data.created_at" name="name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Status</label>
                                <input ng-model="data.status" name="name" ng-disabled="true">
                            </md-input-container>


                        </div>
                    </md-tab>

                    {{-- Hotel Infos --}}
                    <md-tab label="Hotel Detail">
                        <div style="margin-top: 15px;" layout-gt-xs="column">
                            <!--<md-input-container flex-gt-xs>
                                <label>Display Name</label>
                                <input ng-model="data.display_name" name="display_name" required ng-disabled="noDimensionInfo">
                                <div ng-messages="dialogFormType.display_name.$error" ng-show="dialogFormType.display_name.$dirty && dialogFormType.display_name.$invalid">
                                    <div ng-message="required">Display Name is required</div>
                                </div>
                            </md-input-container>-->

                            <md-input-container flex>
                                <label>Hotel Name</label>
                                <input ng-model="data.room_type.hotel.name" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Email</label>
                                <input ng-model="data.room_type.hotel.email" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Phone</label>
                                <input ng-model="data.room_type.hotel.phone" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Website</label>
                                <input ng-model="data.room_type.hotel.website" ng-disabled="true">
                            </md-input-container>

                            <md-input-container flex>
                                <label>Address</label>
                                <input ng-model="data.room_type.hotel.address" ng-disabled="true">
                            </md-input-container>

                        </div>
                    </md-tab>


                </md-tabs>
            </div>
        </md-dialog-content>
        <!--<div class="md-actions" layout="row">
            <div layout="row" layout-align="space-around center" style="width: 100%">
                <md-button type="button" ng-click="close()" class="md-primary">
                    Cancel
                </md-button>
                <md-button type="submit" class="md-primary">
                    Save
                </md-button>
            </div>
        </div>-->
    </form>
</md-dialog>