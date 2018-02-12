const mv = new Vue({
    el: '#app',
    mounted(){
        this.getAllStudents();
    },
    data:{
        showCreateModal: false,
        showUpdateModal: false,
        showDeleteModal: false,
        students: [],
        studentActive: {},
        successMessage: '',
        errorMessage: '',
    },
    computed: {
        displayCreateModal() {
            return (this.showCreateModal) ? 'u-show' : '';
        },
        displayUpdateModal() {
            return (this.showUpdateModal) ? 'u-show' : '';
        },
        displayDeleteModal() {
            return (this.showDeleteModal) ? 'u-show' : '';
        }
    },
    methods: {
        showModal(modal){
            if(modal === 'create'){
                this.showCreateModal = !this.showCreateModal;
            }else if(modal === 'update'){
                this.showUpdateModal = !this.showUpdateModal;
            }else if(modal === 'delete'){
                this.showDeleteModal = !this.showDeleteModal;
            }
        },
        setMessage(message, action){
            if(action === 'create'){
                if(message){
                    this.successMessage = 'Estudiante agregado con éxito!';
                }else{
                    this.errorMessage = 'No se pudo agregar al estudiante';
                }
            }
            else if(action === 'update'){
                if(message){
                    this.successMessage = 'Se actualizaron los datos con éxito!';
                }else{
                    this.errorMessage = 'No se pudo actualizar los datos del estudiante';
                }
            }
            else if(action === 'delete'){
                if(message){
                    this.successMessage = 'Se eliminó los datos del estudiante con éxito!';
                }else{
                    this.errorMessage = 'No se pudo eliminar los datos del estudiante';
                }
            }
            setTimeout(() => {
                this.errorMessage = false;
                this.successMessage = false;
            }, 2000)
        },
        getStudent(modal, student){
            this.showModal(modal);
            this.studentActive = student;
        },
        getAllStudents(){
            axios.get('students/list').then(
                res => {
                    console.log(res);
                    this.students = res.data.students;
                }
            );
        },
        createStudent(e){
            axios.post('students/create',new FormData(e.target)).then(
                res => {
                    console.log(res);
                    this.setMessage(res,'create');
                    this.showModal('create');
                    this.getAllStudents();
                }
            );
        },
        updateStudent(e){
            axios.post('students/update',new FormData(e.target)).then(
                res => {
                    this.setMessage(res,'update');
                    this.showModal('update');
                    this.getAllStudents();
                }
            );
        },
        deleteStudent(e){
            axios.post('students/delete', new FormData(e.target)).then(
                res => {
                    this.setMessage(res,'delete');
                    this.showModal('delete');
                    this.getAllStudents();
                }
            );
        }
    }
});