import { NgModule }       from '@angular/core';
import { CommonModule }   from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

import {DashboardComponent, KeysPipe} from './dashboard.component';
import {MainHeaderComponent} from './mainHeader.component';
import {NewWorkComponent} from './newWork.component';
import {WorkDetailsComponent} from './workDetails.component';

import {WorksService} from './work.service';

const mainRoutes: Routes = [
    { path: 'main', component: DashboardComponent }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(mainRoutes),
    ReactiveFormsModule
  ],
  declarations: [
    DashboardComponent,
    MainHeaderComponent,
    WorkDetailsComponent,
    NewWorkComponent,
    KeysPipe
  ],
  providers: [
    WorksService
  ]
})
export class MainModule {}