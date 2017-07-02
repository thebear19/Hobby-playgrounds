var toDoListApp = angular.module('toDoListApp', ['ui.router']);

toDoListApp.config(function ($locationProvider, $stateProvider) {
    $locationProvider.html5Mode(true);

    var landingState = {
        name: 'welcome',
        url: '/',
        component: 'login'
    };

    var mainState = {
        name: 'main',
        url: '/main',
        template: '<button ui-sref="welcome" type="submit" class="btn btn-primary" >Back</button>'
    };

    $stateProvider.state(landingState);
    $stateProvider.state(mainState);
});