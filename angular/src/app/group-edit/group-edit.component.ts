import { Component, OnInit } from '@angular/core';
import { Group, GroupService } from '../group.service';
import { NgForm } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';

@Component({
  selector: 'app-group-edit',
  templateUrl: './group-edit.component.html',
  styleUrl: './group-edit.component.css',
})
export class GroupEditComponent implements OnInit {
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

  onSubmit(form: NgForm) {
    this.message = '';

    this.groupService.update(this.group.id, form.value).subscribe({
      next: (res) => {
        this.router.navigate(['/group/show', this.group.id]);
        this.message = res.message
          ? res.message
          : 'Le groupe a bien été modifié';
      },
      error: (e) => (this.errors = 'Erreur: ' + e),
    });
  }
}
