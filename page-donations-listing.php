<?php
/*
 * Template Name: WP-AFA Donations Listing Exmple
 */
get_header ();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div ng-app="wpafaMainModule">
                <div ng-controller="wpafaCoreController">
                    <div ng-controller="wpafaegController" ng-init='wpafaeg.init("<?php echo home_url() ?>","donations","donationsData");'>
                        <h1>Donations List </h1>
                        <div style="text-align:right;padding-bottom:20px;">
                            <button type="button" ng-click="wpafaeg.addNewDonation()"><i class="fa fa-plus-circle"></i> Add New Donation</button>

                        </div>
                        <div>
                            <table class="pure-table">
                                <thead>
                                    <tr>
                                        <th>
                                            Donation
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>
                                            Remarks
                                        </th>
                                        <th>
                                            Changes Info.
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="donation in dataService.donationsData.donations_list">
                                        <td>
                                            <div ng-if="donation.editing_mood == false">
                                                {{donation.contact_name}}
                                            </div>
                                            <div ng-if="donation.editing_mood == true">
                                                <select ng-model="donation.temp_contact" ng-options="contact as contact.contact_name for contact in dataService.donationsData.contacts_list track by contact.id"></select>
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="donation.editing_mood == false">
                                                {{donation.date}}
                                            </div>
                                            <div ng-if="donation.editing_mood == true">
                                                <input type="date" ng-model="donation.temp_date" />
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="donation.editing_mood == false">
                                                {{donation.amount | number:0}}
                                            </div>
                                            <div ng-if="donation.editing_mood == true">
                                                <input type="number" ng-model="donation.temp_amount" />
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="donation.editing_mood == false">
                                                {{donation.remarks}}
                                            </div>
                                            <div ng-if="donation.editing_mood == true">
                                                <input type="text" ng-model="donation.temp_remarks" />
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fa fa-user" title="Created By: {{donation.created_by}} on {{donation.created_on}}, Last Modified By: {{donation.modified_by}} on {{donation.modified_on}}."></i>
                                        </td>
                                        <td>
                                            <button type="button" class="link-button" ng-if="donation.editing_mood == false" ng-click="donation.editing_mood = true">Edit</button>
                                            <button type="button" class="link-button" ng-if="donation.editing_mood == true" ng-click="wpafaeg.saveDonation(donation)">Save</button>
                                            <button type="button" class="link-button" ng-if="donation.editing_mood == true" ng-click="wpafaeg.cancelItem(dataService.donationsData.donations_list,donation)">Cancel</button>
                                            <button type="button" class="link-button" ng-if="donation.is_new == false" ng-click="wpafaeg.removeDonation(donation)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </main>
        <!-- .site-main -->

        <?php get_sidebar( 'content-bottom' ); ?>

    </div>
    <!-- .content-area -->

    <?php get_sidebar(); ?>
        <?php get_footer(); ?>
