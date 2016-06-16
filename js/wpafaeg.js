wpafaNgApp.controller("wpafaegController", ['$rootScope', '$scope', '$http', function ($rootScope, $scope, $http) {
    $scope.wpafaeg = {};
    $rootScope.$on('wpafa:requestSent', function () {

    });
    $rootScope.$on('wpafa:responseReturned', function (event, responseData) {
        console.log(['wp-afa-eg: Response Returned', responseData]);
        if (responseData.valid) {
            // Contacts Response
            if (responseData.dataKey == "contactsData") {
                $scope.dataService["contactsData"] = responseData.data;
                console.log($scope.dataService);
            } else if (responseData.dataKey == "contactsRemoved") {
                var length = $scope.dataService.contactsData.contacts_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.id == $scope.dataService.contactsData.contacts_list[i].id) {
                        $scope.dataService.contactsData.contacts_list.splice(i, 1);
                    }
                }
            } else if (responseData.dataKey == "contactUpdated") {
                var length = $scope.dataService.contactsData.contacts_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.id == $scope.dataService.contactsData.contacts_list[i].id) {
                        $scope.dataService.contactsData.contacts_list[i] = responseData.data;
                    }
                }
            } else if (responseData.dataKey == "contactCreated") {
                var length = $scope.dataService.contactsData.contacts_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.guid == $scope.dataService.contactsData.contacts_list[i].guid) {
                        $scope.dataService.contactsData.contacts_list[i] = responseData.data;
                    }
                }
            }
            // Donations Response
            if (responseData.dataKey == "donationsData") {
                $scope.dataService["donationsData"] = responseData.data;
                var length = $scope.dataService.donationsData.donations_list.length;
                for (i = length - 1; i >= 0; i--) {
                    $scope.dataService.donationsData.donations_list[i].temp_date = new Date(Date.parse($scope.dataService.donationsData.donations_list[i].date));
                }
                console.log($scope.dataService);
            } else if (responseData.dataKey == "donationsRemoved") {
                var length = $scope.dataService.donationsData.donations_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.id == $scope.dataService.donationsData.donations_list[i].id) {
                        $scope.dataService.donationsData.donations_list.splice(i, 1);
                    }
                }
            } else if (responseData.dataKey == "donationUpdated") {
                var length = $scope.dataService.donationsData.donations_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.id == $scope.dataService.donationsData.donations_list[i].id) {
                        $scope.dataService.donationsData.donations_list[i] = responseData.data;
                    }
                }
            } else if (responseData.dataKey == "donationCreated") {
                var length = $scope.dataService.donationsData.donations_list.length;
                for (i = length - 1; i >= 0; i--) {
                    if (responseData.data.guid == $scope.dataService.donationsData.donations_list[i].guid) {
                        $scope.dataService.donationsData.donations_list[i] = responseData.data;
                    }
                }
            }
        }
    });

    $scope.wpafaeg.init = function (baseurl, datasource, dataKey) {
        $scope.init(baseurl);
        $scope.dataService.processRequest("wpafaeg", datasource, "list_data", {}, dataKey);
    }
    $scope.wpafaeg.generateUUID = function () {
        var d = new Date().getTime();
        var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
        return uuid;
    }
    $scope.wpafaeg.addNewContact = function () {
        if ($scope.dataService.contactsData.contacts_list != undefined) {
            $scope.dataService.contactsData.contacts_list.push({
                is_new: true,
                editing_mood: true,
                guid: $scope.wpafaeg.generateUUID()
            });
        }
    }
    $scope.wpafaeg.addNewDonation = function () {
        if ($scope.dataService.donationsData.donations_list != undefined) {
            $scope.dataService.donationsData.donations_list.push({
                is_new: true,
                editing_mood: true,
                guid: $scope.wpafaeg.generateUUID()
            });
        }
    }
    $scope.wpafaeg.cancelItem = function (arr, item) {
        if (item.is_new == true) {
            var index = arr.indexOf(item);
            arr.splice(index, 1);
        } else {
            item.editing_mood = false;
        }
    }
    $scope.wpafaeg.removeContact = function (item) {
        if (item.is_new == true) {
            // New Non Saved Item
            // Just Remove It From The Array

            var index = $scope.dataService.contactsData.contacts_list.indexOf(item);
            $scope.dataService.contactsData.contacts_list.splice(index, 1);
        } else {
            $scope.dataService.processRequest("wpafaeg", "contacts", "delete_item", item, "contactsRemoved");
        }
    }
    $scope.wpafaeg.removeDonation = function (item) {
        if (item.is_new == true) {
            // New Non Saved Item
            // Just Remove It From The Array

            var index = $scope.dataService.donationsData.donations_list.indexOf(item);
            $scope.dataService.donationsData.donations_list.splice(index, 1);
        } else {
            $scope.dataService.processRequest("wpafaeg", "donations", "delete_item", item, "donationsRemoved");
        }
    }
    $scope.wpafaeg.saveContact = function (item) {
        var dataKey = "contactUpdated";

        if (item.is_new == true) {
            dataKey = "contactCreated";
        }

        $scope.dataService.processRequest("wpafaeg", "contacts", "save_item", item, dataKey);
    }
    $scope.wpafaeg.saveDonation = function (item) {
        var dataKey = "donationUpdated";

        if (item.is_new == true) {
            dataKey = "donationCreated";
        }

        $scope.dataService.processRequest("wpafaeg", "donations", "save_item", item, dataKey);
    }
  }]);
