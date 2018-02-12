<?php
/**
 * Created by PhpStorm.
 * User: Angy
 * Date: 9/02/2018
 * Time: 16:46
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Students</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/public/libraries/materialize/css/materialize.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<main id="app" class="container center">

    <nav class="nav-extended blue lighten-2">
        <div class="nav-content">
            <span class="nav-title">CRUD - ESTUDIANTES </span>
            <button class="btn-floating btn-large halfway-fab waves-effect waves-light blue" @click="showModal('create')">
                <i class="material-icons">add</i>
            </button>
        </div>
    </nav>

    <!-- Messages -->
    <transition name="fade">
        <p class="u-flexColumnCenter green accent-1 green-text text-darken-4" v-if="successMessage">
            <i class="material-icons prefix">check_circle</i>
            {{ successMessage }}
        </p>
        <p class="u-flexColumnCenter red accent-1 red-text text-darken-4" v-if="errorMessage">
            <i class="material-icons prefix">error</i>
            {{ errorMessage }}
        </p>
    </transition>
    <!-- List -->
    <transition name="fade">
        <table class="responsive-table highlight mt-5" v-if="students.length">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo Electronico</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in students" :key="student.id">
                    <td> {{ student.id }}</td>
                    <td> {{ student.name }}</td>
                    <td> {{ student.lastname }}</td>
                    <td> {{ student.email}}</td>
                    <td>
                        <button class="btn btn-floating" @click="getStudent('update',student)">
                            <i class="material-icons">edit</i>
                        </button>
                        <button class="btn btn-floating red" @click="getStudent('delete',student)">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <h6  v-else="students.length"> No hay nadie :'( </h6>
    </transition>
    <!-- Modal Create-->
    <transition name="fade">
        <section :class="[ 'ModalWindow', displayCreateModal ]" v-if="showCreateModal">
            <div class="ModalWindow-container">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center blue-text mt-5">Agregar Estudiante</h4>
                        </div>
                    </div>
                    <div class="row valign-wrapper">
                        <div class="col s12">
                            <form class="ModalWindow-content" @submit.prevent="createStudent">
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input name="name" type="text" placeholder="Nombre" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input name="lastname" type="text" placeholder="Apellido" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">web</i>
                                    <input name="email" type="text" placeholder="Correo" required>
                                </div>
                                <div class="row" style="margin-top: 15px">
                                    <a class="waves-effect waves-blue btn-flat " @click="showModal('create')">Cancelar</a>
                                    <button class="btn waves-effect waves-light blue" type="submit" >
                                        Guardar<i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </transition>
    <!-- Modal Update-->
    <transition name="fade">
        <section :class="['ModalWindow', displayUpdateModal]" v-if="showUpdateModal">
            <div class="ModalWindow-container">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center blue-text mt-5">Editar Estudiante</h4>
                        </div>
                    </div>
                    <div class="row valign-wrapper">
                        <div class="col s12">
                            <form class="ModalWindow-content" @submit.prevent="updateStudent">
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input name="name" type="text" placeholder="Nombre" :value="studentActive.name" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input name="lastname" type="text" placeholder="Apellido" :value="studentActive.lastname" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">web</i>
                                    <input name="email" type="text" placeholder="Correo" :value="studentActive.email" required>
                                </div>
                                <div class="input-field">
                                    <input name="id" type="hidden" :value="studentActive.id">
                                </div>
                                <div class="row" style="margin-top: 15px">
                                    <a class="waves-effect waves-blue btn-flat " @click="showModal('update')">Cancelar</a>
                                    <button class="btn waves-effect waves-light blue" type="submit" >
                                        Guardar Cambios<i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </transition>
    <!-- Modal Delete-->
    <transition name="fade">
        <section :class="['ModalWindow', displayDeleteModal ]" v-if="showDeleteModal">
            <div class="ModalWindow-container">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center blue-text mt-5">Eliminar Estudiante</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <form @submit.prevent="deleteStudent">
                                <div class="input-field">
                                    <p class="flow-text center">¿Estás seguro de eliminar al estudiante {{ studentActive.name }} ? </p>
                                    <input name="id" type="hidden" :value="studentActive.id" required>
                                </div>
                                <div class="row mt-5">
                                    <a class="waves-effect waves-blue btn-flat" @click="showModal('delete')">Cancelar</a>
                                    <button class="btn waves-effect waves-light blue" type="submit">
                                        Eliminar<i class="material-icons right">delete</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </transition>

</main>

<script src="/public/libraries/materialize/js/jquery-3.1.0.min.js"></script>
<script src="/public/libraries/materialize/js/materialize.min.js"></script>
<script src="/public/libraries/vue/vue.js"></script>
<script src="/public/libraries/vue/axios.min.js"></script>
<script src="/public/js/main.js"></script>

</body>
</html>