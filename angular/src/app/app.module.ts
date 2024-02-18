import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { Routes } from '@angular/router';
import { GroupListComponent } from './group-list/group-list.component';
import { GroupEditComponent } from './group-edit/group-edit.component';
import { GroupShowComponent } from './group-show/group-show.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { BsDropdownModule } from 'ngx-bootstrap/dropdown';
import { HomeComponent } from './home/home.component';
import { ImportExcelComponent } from './import-excel/import-excel.component';

@NgModule({
  declarations: [
    AppComponent,
    GroupListComponent,
    GroupEditComponent,
    GroupShowComponent,
    HomeComponent,
    ImportExcelComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    CommonModule,
    NgbModule,
    BsDropdownModule,
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}

const routes: Routes = [];
