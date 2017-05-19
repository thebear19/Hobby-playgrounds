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
var work_service_1 = require("./work.service");
var DashboardComponent = (function () {
    function DashboardComponent(worksService) {
        this.worksService = worksService;
        this.works = {};
        this.errorMessage = '';
    }
    DashboardComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.worksService.getWorks()
            .subscribe(function (p) { return _this.works = p; }, function (e) { return _this.errorMessage = e; });
    };
    DashboardComponent.prototype.showWorkDetail = function (work) {
        var _this = this;
        this.worksService.getWorkDetails(work)
            .subscribe(function (p) { return _this.workdetail = p; }, function (e) { return _this.errorMessage = e; }, function () { return _this.selectedWork = work; });
    };
    return DashboardComponent;
}());
DashboardComponent = __decorate([
    core_1.Component({
        template: "\n    <main-header (onRefresh)=\"ngOnInit()\"></main-header>\n    <div class=\"row\">\n        <div class=\"col-12\">\n            <div class=\"card\">\n                <div class=\"card-block row\">\n                    <div class=\"col-6\">\n                        <ul class=\"list-group\">\n                            <li *ngFor=\"let work of (works | objects)\"\n                            [class.active]=\"work.value === selectedWork\"\n                            class=\"list-group-item\"\n                            (click)=\"showWorkDetail(work.value)\">\n                                {{work.value.value}} #{{work.value.key}}\n                            </li>\n                        </ul>\n                    </div>\n                    <div class=\"col-6\">\n                        <work-details [workDetails]=\"workdetail\"></work-details>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n    "
    }),
    __metadata("design:paramtypes", [work_service_1.WorksService])
], DashboardComponent);
exports.DashboardComponent = DashboardComponent;
var KeysPipe = (function () {
    function KeysPipe() {
    }
    KeysPipe.prototype.transform = function (value, args) {
        var objects = [];
        for (var key in value) {
            objects.push({ key: key, value: value[key] });
        }
        return objects;
    };
    return KeysPipe;
}());
KeysPipe = __decorate([
    core_1.Pipe({ name: 'objects' }),
    __metadata("design:paramtypes", [])
], KeysPipe);
exports.KeysPipe = KeysPipe;
//# sourceMappingURL=dashboard.component.js.map