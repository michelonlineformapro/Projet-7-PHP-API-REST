import { Injectable } from '@angular/core';
//Appel de http client pour communiquer avec le back php
import {HttpClient} from "@angular/common/http";
//Appel du model
import {UsersModel} from "./UsersModel";
//Appel des observable (ex: promise)
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  PHP_API_SERVER = "http://localhost/fullapi"
  //A init du service on appel hhtpclient
  //c un appel d'injection de dépendance
  constructor(private httpclient: HttpClient) { }

  readUsers(): Observable<UsersModel[]>{
    return this.httpclient.get<UsersModel[]>(`${this.PHP_API_SERVER}/api/readUser.php`)
  }

  createUsers(user: UsersModel):Observable<UsersModel>{
    return this.httpclient.post<UsersModel>(`${this.PHP_API_SERVER}/api/createUser.php`, user)
  }

  updateUsers(user: UsersModel){
    return this.httpclient.put<UsersModel>(`${this.PHP_API_SERVER}/api/updateUser.php`,user)
  }

  deleteOneUsers(id: number){
    return this.httpclient.delete<UsersModel>(`${this.PHP_API_SERVER}/api/deleteUser.php/?id=${id}`)
  }
}
