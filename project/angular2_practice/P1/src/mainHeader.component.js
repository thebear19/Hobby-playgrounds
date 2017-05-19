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
var MainHeaderComponent = (function () {
    function MainHeaderComponent() {
        this.onRefresh = new core_1.EventEmitter();
        this.id_workLabel = "addNewWork";
    }
    MainHeaderComponent.prototype.showNewWork = function (event) {
        event.preventDefault();
        $('#addNewWork').modal({
            backdrop: "static"
        });
    };
    MainHeaderComponent.prototype.closeNewWork = function (event) {
        $('#addNewWork').modal('hide');
        this.onRefresh.emit(true);
    };
    return MainHeaderComponent;
}());
__decorate([
    core_1.Output(),
    __metadata("design:type", Object)
], MainHeaderComponent.prototype, "onRefresh", void 0);
MainHeaderComponent = __decorate([
    core_1.Component({
        selector: 'main-header',
        template: "\n    <nav class=\"navbar navbar-inverse bg-inverse navbar-toggleable-md\">\n        <a class=\"navbar-brand\" href=\"#\">A2</a>\n\n        <div class=\"collapse navbar-collapse\">\n            <ul class=\"navbar-nav mr-auto\">\n                <li class=\"nav-item active\">\n                    <a class=\"nav-link\" href=\"#\">Home <span class=\"sr-only\">(current)</span></a>\n                </li>\n                <li class=\"nav-item\">\n                    <a class=\"nav-link\" href=\"#\" (click)=\"showNewWork($event)\">New</a>\n                </li>\n            </ul>\n\n            <ul class=\"navbar-nav justify-content-end\">\n                <li class=\"nav-item\">\n                    <a class=\"nav-link\" href=\"/login\">Logout</a>\n                </li>\n            </ul>\n        </div>\n    </nav>\n    <new-work [idName]=\"id_workLabel\" (result)=\"closeNewWork($event)\"></new-work>\n    "
    }),
    __metadata("design:paramtypes", [])
], MainHeaderComponent);
exports.MainHeaderComponent = MainHeaderComponent;
//# sourceMappingURL=mainHeader.component.js.map