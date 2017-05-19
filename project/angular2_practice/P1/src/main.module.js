"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require("@angular/core");
var common_1 = require("@angular/common");
var router_1 = require("@angular/router");
var forms_1 = require("@angular/forms");
var dashboard_component_1 = require("./dashboard.component");
var mainHeader_component_1 = require("./mainHeader.component");
var newWork_component_1 = require("./newWork.component");
var workDetails_component_1 = require("./workDetails.component");
var work_service_1 = require("./work.service");
var mainRoutes = [
    { path: 'main', component: dashboard_component_1.DashboardComponent }
];
var MainModule = (function () {
    function MainModule() {
    }
    return MainModule;
}());
MainModule = __decorate([
    core_1.NgModule({
        imports: [
            common_1.CommonModule,
            router_1.RouterModule.forChild(mainRoutes),
            forms_1.ReactiveFormsModule
        ],
        declarations: [
            dashboard_component_1.DashboardComponent,
            mainHeader_component_1.MainHeaderComponent,
            workDetails_component_1.WorkDetailsComponent,
            newWork_component_1.NewWorkComponent,
            dashboard_component_1.KeysPipe
        ],
        providers: [
            work_service_1.WorksService
        ]
    }),
    __metadata("design:paramtypes", [])
], MainModule);
exports.MainModule = MainModule;
//# sourceMappingURL=main.module.js.map