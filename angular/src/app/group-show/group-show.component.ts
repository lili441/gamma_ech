import { Component } from '@angular/core';
import { Group, GroupService } from '../group.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-group-show',
  templateUrl: './group-show.component.html',
  styleUrl: './group-show.component.css',
})
export class GroupShowComponent {
  idGroup = 0;
  group: Group = {
    id: 0,
    name: '',
    origin: '',
    city: '',
    startDate: 0,
    endDate: 0,
    creator: '',
    member: 0,
    musicalStyle: '',
    description: '',
  };

  message = '';
  errors: string = '';

  constructor(
    private groupService: GroupService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.idGroup = +this.route.snapshot.paramMap.get('id')!;
    this.loadData();
  }

  private loadData() {
    this.groupService.getGroupById(this.idGroup).subscribe(
      (data) => {
        this.group = data;
      },
      (error) => {
        this.errors = 'Erreur lors du chargement des données: ' + error;
      }
    );
  }

  editGroup(idGroup: number) {
    this.router.navigate(['/group/edit', idGroup]);
  }

  deleteGroup(idGroup: number): void {
    if (confirm('Voulez-vous vraiment supprimer ce groupe ?')) {
      this.groupService.delete(idGroup).subscribe(
        () => {
          this.router.navigate(['/group']);
        },
        (error) => {
          this.errors = 'Erreur lors de la suppression: ' + error;
        }
      );
    }
  }
}
