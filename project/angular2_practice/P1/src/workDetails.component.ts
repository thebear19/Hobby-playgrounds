import {Component, Input} from '@angular/core';

@Component({
    selector: 'work-details',
    template: `
    <div class="card" *ngIf="workDetails">
        <div class="card-block">
            <h2 class="card-title">Work Detail</h2>
            <div class="row">
                <label class="col-2">ID:</label>
                <div>{{workDetails.key}}</div>
            </div>

            <div class="row">
                <label class="col-2">Detail:</label>
                <div>{{workDetails.value}}</div>
            </div>
        </div>
    </div>
    `
})

export class WorkDetailsComponent {
    @Input() workDetails;
}