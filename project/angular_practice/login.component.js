angular.
    module('toDoListApp').
    component('login', {
        templateUrl: 'login.template.html',
        controller: function loginController($state) {
            var self = this;

            self.submitLogin = function () {
                if (this.idBox == "admin" && this.passBox == "admin") {
                    console.log("Login!!");
                    $state.go("main");
                }
            };
        }
    });