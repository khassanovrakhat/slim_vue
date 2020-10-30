<template>
  <div class="signup container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header"> Register</h1>
    <form v-on:submit="signup">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Name" v-model="signup.first_name">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" v-model="signup.last_name">
            </div>
            <div class="form-group">
                <label>Patronymic</label>
                <input type="text" class="form-control" placeholder="Patronymic" v-model="signup.patronymic">
            </div>
         <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Password" v-model="signup.password">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" placeholder="Email" v-model="signup.email">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
import Alert from './Alert'
import axios from 'axios'
export default {
  name: 'Signup',
  data () {
    return {
      register: {},
      alert:''
    }
  },
  methods: {
        signup(e){
            if(!this.signup.first_name || !this.signup.last_name || !this.signup.email){
                alert('Please fill in all required fields');
            } else {
                let newRegister = {
                    first_name: this.signup.first_name,
                    last_name: this.signup.last_name,
                    patronymic: this.signup.patronymic,
                    password: this.signup.password,
                    email: this.signup.email
                }
                axios.post('http://localhost/slimapi/users/register', newRegister)
                    .then(
                    user => {// console.log(user);
                        alert(`Account Created for ${this.signup.email}`);
                        this.$router.go({ path: this.$router.path });
                    },
                    err => {
                        alert(err.message);
                    });

                e.preventDefault();
            }
            // console.log('123');
            e.preventDefault();
        }
    },
    components: {
        Alert
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
