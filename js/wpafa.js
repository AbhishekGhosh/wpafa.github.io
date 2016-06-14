/*
 WP-AFA Main Angular Module & Controller 
 v0.1.0
 (c) 2016 
 https://github.com/hasanhalabi/wpafa.github.io
 License: MIT
*/
var wpafaNgApp = angular.module("wpafaMainModule", []);

wpafaNgApp.controller("wpafaCoreController", ['$rootScope', '$scope', '$http', function ($rootScope, $scope, $http) {

    // Debug & Console Messages
    var logging = {
        enabled: true,
        toConsole: function (logData) {
            if (this.enabled) {
                console.log(logData);
            }
        }
    };
    // App Configuration
    $scope.appConfig = {
        baseurl: ''
    }
    $scope.init = function (baseurl) {
        if (baseurl.toString().slice(-1) != "/") {
            baseurl = baseurl + "/";
        }
        $scope.appConfig.baseurl = baseurl;
    }

    $scope.initWithRequest = function (baseurl, theDomain, theDataSource, theDataSegment, theParams, theDataKey) {
        $scope.init(baseurl);
        $scope.dataService.processRequest(theDomain, theDataSource, theDataSegment, theParams, theDataKey);
    }


    $scope.dataService = {};
    $scope.dataService.processRequest = function (theDomain, theDataSource, theDataSegment, theParams, theDataKey) {
        $rootScope.$emit('wpafa:requestSent');
        var requestData = {
            domain: theDomain,
            datasource: theDataSource,
            datasegment: theDataSegment,
            params: theParams
        };
        logging.toConsole(['wp-afa: Request Sent', requestData]);
        $http({
            method: 'POST',
            url: $scope.appConfig.baseurl + 'wpafa-api',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: "requestData=" + angular.toJson(requestData)
        }).then(function (response) {
            // Success
            logging.toConsole('wp-afa: $http Success');
            if (response.data.result == "ok") {
                logging.toConsole(['wp-afa: Data Ok!', response.data.theData]);

                $rootScope.$emit('wpafa:responseReturned', {
                    valid: true,
                    dataKey: theDataKey,
                    data: response.data.theData
                });
            } else {
                logging.toConsole(['wp-afa: Data NOT Ok!', response.data.theData]);
                $rootScope.$emit('wpafa:responseReturned', {
                    key: dataKey,
                    data: response.data.theData
                });
            }

        }, function (response) {
            // Failed
            logging.toConsole(['wp-afa: $http Failed', response]);
            $rootScope.$emit('wpafa:event:responseReturned', {
                valid: false,
                data: response
            });
        });
    };
            }]);
