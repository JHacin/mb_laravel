@extends('layouts.app')

@section('content')
   <section class="section">
       <div class="container">
           <form action="">
               <div class="field">
                   <label class="label" for="email">Email</label>
                   <div class="control has-icons-left has-icons-right">
                       <input class="input" type="email" id="email" name="email" placeholder="Email">
                       <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
                   </div>
               </div>

               <div class="field">
                   <label class="label" for="password">Geslo</label>
                   <div class="control has-icons-left has-icons-right">
                       <input class="input" type="password" id="password" name="password" placeholder="Geslo">
                       <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
                   </div>
               </div>

               <div class="field">
                   <div class="control">
                       <button class="button is-link">Prijava</button>
                   </div>
               </div>
           </form>
       </div>
   </section>
@endsection
