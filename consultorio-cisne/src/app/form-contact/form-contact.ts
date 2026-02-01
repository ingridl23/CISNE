import { Component, OnInit } from '@angular/core';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
// Update the path below to the actual location of DataService
import { DataService } from '../services/data.service';
@Component({
  selector: 'app-form-contact',
  imports: [],
  templateUrl: './form-contact.html',
  styleUrl: './form-contact.scss'
})
export class FormContact implements OnInit{
  form!: FormGroup;
  constructor(private fb: FormBuilder, private data: DataService) {}
  ngOnInit() {
    this.form = this.fb.group({
      nombre: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      mensaje: ['', Validators.required],
      nota: ['']

    });
  }
  submit() {
    if (this.form.invalid) return;
    this.data.addContacto(this.form.value).then(() => {
      // notificar éxito
    });
  }

}




   