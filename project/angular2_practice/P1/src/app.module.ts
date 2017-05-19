import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpModule} from '@angular/http';
import { RouterModule, Routes } from '@angular/router';

import {AppComponent}          from './app.component';
import {LoginFormComponent} from './loginForm.component';
import {AlertComponent} from './alert.component';
import {MainModule}     from './main.module';

import {LoginService} from './login.service';

const appRoutes: Routes = [
    { path: 'login', component: LoginFormComponent },

    { path: '',   redirectTo: '/login', pathMatch: 'full' }
];


@NgModule({
    imports: [
        BrowserModule,
        ReactiveFormsModule,
        HttpModule,
        RouterModule.forRoot(appRoutes),
        MainModule
    ],
    providers: [
        LoginService
    ],
    declarations: [
        AppComponent,
        LoginFormComponent,
        AlertComponent
    ],
    bootstrap: [
        AppComponent
    ]
})
export class AppModule { }