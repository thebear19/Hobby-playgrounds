import {Component, Input} from '@angular/core';

@Component({
    selector: 'alert',
    template: `<div class="alert alert-danger"><b>{{message}}</b></div>`
})

export class AlertComponent {
    @Input() message: string = '';
}