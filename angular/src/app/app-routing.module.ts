import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { GroupListComponent } from './group-list/group-list.component';
import { GroupShowComponent } from './group-show/group-show.component';
import { GroupEditComponent } from './group-edit/group-edit.component';
import { HomeComponent } from './home/home.component';
import { ImportExcelComponent } from './import-excel/import-excel.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'import', component: ImportExcelComponent },
  { path: 'group', component: GroupListComponent },
  { path: 'group/show/:id', component: GroupShowComponent },
  { path: 'group/edit/:id', component: GroupEditComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
