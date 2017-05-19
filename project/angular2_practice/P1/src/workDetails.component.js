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
var WorkDetailsComponent = (function () {
    function WorkDetailsComponent() {
    }
    return WorkDetailsComponent;
}());
__decorate([
    core_1.Input(),
    __metadata("design:type", Object)
], WorkDetailsComponent.prototype, "workDetails", void 0);
WorkDetailsComponent = __decorate([
    core_1.Component({
        selector: 'work-details',
        template: "\n    <div class=\"card\" *ngIf=\"workDetails\">\n        <div class=\"card-block\">\n            <h2 class=\"card-title\">Work Detail</h2>\n            <div class=\"row\">\n                <label class=\"col-2\">ID:</label>\n                <div>{{workDetails.key}}</div>\n            </div>\n\n            <div class=\"row\">\n                <label class=\"col-2\">Detail:</label>\n                <div>{{workDetails.value}}</div>\n            </div>\n        </div>\n    </div>\n    "
    }),
    __metadata("design:paramtypes", [])
], WorkDetailsComponent);
exports.WorkDetailsComponent = WorkDetailsComponent;
//# sourceMappingURL=workDetails.component.js.map