import { Component, OnInit } from '@angular/core';
//appel du service qui appel usersModel
import {ApiService} from "../api.service";
import {UsersModel} from "../UsersModel";
import {first} from "rxjs/operators";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  //Variables et constante
  //Appel du tableau userModel
  users: any = []
  public selectedUser: UsersModel = {id: null, email: null, password: null}
  form: any

  //lors de l'appel composant Dashbord le constructeur appel api Service
  //Injection du service via un variable privée
  constructor(private apiService: ApiService ) { }

  //Ici on appel la methode readUser du service

  ngOnInit(): void {
    this.readAllUser()
  }

  readAllUser(){
    this.apiService.readUsers().subscribe((users: UsersModel[]) => {
      this.users = users
      console.log(this.users)
    })
  }




  //Creer ou mettre a jour le membres
  createOrUpdateUser(form){
    //Recup du tableau utilisateur et recup de id
    if(this.selectedUser && this.selectedUser.id){
      //le form recup id
      form.value.id = this.selectedUser.id
      //appel de la methode update du services
      this.apiService.updateUsers(form.value).subscribe((user: UsersModel) => {
        console.log("Membre mis a jour", user)
      })
    }else{
      //Sinon creation si id est null
      this.apiService.createUsers(form.value).subscribe((user:UsersModel) => {
        this.readAllUser()
        console.log("Membre creer", user)
      })
    }
  }
  //Recup par id
  getOneUser(user: UsersModel){
    this.selectedUser = user
  }

  //Supprimer membre
  deleteUser(id:number){
    this.apiService.deleteOneUsers(id).subscribe((users: UsersModel) => {
      this.readAllUser()
      console.log("Membre supprimé avec succès", users)
    })
  }
}
