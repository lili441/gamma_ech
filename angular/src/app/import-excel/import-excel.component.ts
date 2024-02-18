import { Component, OnInit } from '@angular/core';
import { GroupService } from '../group.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-import-excel',
  templateUrl: './import-excel.component.html',
  styleUrl: './import-excel.component.css',
})
export class ImportExcelComponent implements OnInit {
  selectedFile: File | null = null;
  message = '';

  constructor(private groupService: GroupService, private router: Router) {}

  ngOnInit() {}

  onFileSelected(event: any): void {
    if (event.target.files[0] && this.isXlsxFile(event.target.files[0].name)) {
      this.selectedFile = event.target.files[0];
      this.message = '';
    } else {
      this.selectedFile = null;
      this.message =
        'Mauvais format de fichier. Veuillez importer un fichier au format xls ou xlsx.';
    }
  }
  uploadFile(): void {
    if (this.selectedFile) {
      const formData = new FormData();
      formData.append('file', this.selectedFile);

      this.groupService.create(formData).subscribe(
        (response: any) => {
          console.log('File uploaded successfully', response);
          this.router.navigate(['/group']);
        },
        (error) => {
          console.error('Error uploading file', error);
        }
      );
    }
  }

  isXlsxFile(fileName: string): boolean {
    return fileName.endsWith('.xlsx');
  }

  navigateToList() {
    this.router.navigate(['/group']);
  }
}
