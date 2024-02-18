import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Group {
  id: Number;
  name: String;
  origin: String;
  city: String;
  startDate: Number;
  endDate: Number;
  creator: String;
  member: Number;
  musicalStyle: String;
  description: String;
}

const API_URL: string = 'http://localhost:8000';

@Injectable({
  providedIn: 'root',
})
export class GroupService {
  constructor(private http: HttpClient) {}

  getGroups(): Observable<Group[]> {
    return this.http.get<Group[]>(`${API_URL}/group`);
  }

  getGroupById(id: number): Observable<Group> {
    return this.http.get<Group>(`${API_URL}/group/${id}`);
  }

  create(data: any): Observable<any> {
    return this.http.post(`${API_URL}/group/create`, data);
  }

  update(id: any, data: any): Observable<any> {
    return this.http.put(`${API_URL}/group/update/${id}`, data);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${API_URL}/group/delete/${id}`);
  }
}
