<?php
/*
 * Template Name: WP-AFA Contact Listing Exmple
 */
get_header ();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div ng-app="wpafaMainModule">
                <div ng-controller="wpafaCoreController">
                    <div ng-controller="wpafaegController" ng-init='wpafaeg.init("<?php echo home_url() ?>","contacts","contactsData");'>
                        <h1>Contacts List </h1>
                        <div style="text-align:right;padding-bottom:20px;">
                            <button type="button" ng-click="wpafaeg.addNewContact()"><i class="fa fa-plus-circle"></i> Add New Contact</button>

                        </div>
                        <div>
                            <table class="pure-table">
                                <thead>
                                    <tr>
                                        <th>
                                            First Name
                                        </th>
                                        <th>
                                            Last Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Phone
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
                                    <tr ng-repeat="contact in dataService.contactsData.contacts_list">
                                        <td>
                                            <div ng-if="contact.editing_mood == false">
                                                {{contact.first_name}}
                                            </div>
                                            <div ng-if="contact.editing_mood == true">
                                                <input type="text" ng-model="contact.temp_first_name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="contact.editing_mood == false">
                                                {{contact.last_name}}
                                            </div>
                                            <div ng-if="contact.editing_mood == true">
                                                <input type="text" ng-model="contact.temp_last_name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="contact.editing_mood == false">
                                                {{contact.email}}
                                            </div>
                                            <div ng-if="contact.editing_mood == true">
                                                <input type="email" ng-model="contact.temp_email" />
                                            </div>
                                        </td>
                                        <td>
                                            <div ng-if="contact.editing_mood == false">
                                                {{contact.phone}}
                                            </div>
                                            <div ng-if="contact.editing_mood == true">
                                                <input type="text" ng-model="contact.temp_phone" />
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fa fa-user" title="Created By: {{contact.created_by}} on {{contact.created_on}}, Last Modified By: {{contact.modified_by}} on {{contact.modified_on}}."></i>
                                        </td>
                                        <td>
                                            <button type="button" class="link-button" ng-if="contact.editing_mood == false" ng-click="contact.editing_mood = true">Edit</button>
                                            <button type="button" class="link-button" ng-if="contact.editing_mood == true" ng-click="wpafaeg.saveContact(contact)">Save</button>
                                            <button type="button" class="link-button" ng-if="contact.editing_mood == true" ng-click="wpafaeg.cancelItem(dataService.contactsData.contacts_list,contact)">Cancel</button>
                                            <button type="button" class="link-button" ng-if="contact.is_new == false" ng-click="wpafaeg.removeContact(contact)">Delete</button>
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
