import { Component, OnInit } from '@angular/core';
import { GroupService } from '../group.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-group-list',
  templateUrl: './group-list.component.html',
  styleUrl: './group-list.component.css',
})
export class GroupListComponent implements OnInit {
  groups: any;
  message = '';
  errors: string = '';

  constructor(private groupService: GroupService, private router: Router) {}

  ngOnInit() {
    this.getGroups();
  }

  getGroups() {
    this.groupService.getGroups().subscribe((response) => {
      this.groups = response;
    });
  }

  editGroup(idGroup: number) {
    this.router.navigate(['/group/edit', idGroup]);
  }

  deleteGroup(idGroup: number): void {
    if (confirm('Voulez-vous vraiment supprimer ce groupe ?')) {
      this.groupService.delete(idGroup).subscribe(
        () => {
          this.groups = this.groups.filter(
            (group: any) => group.id !== idGroup
          );
          this.message = 'Suppression réussie';
        },
        (error) => {
          this.errors = 'Erreur lors de la suppression: ' + error;
        }
      );
    }
  }
}
