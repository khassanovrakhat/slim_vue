<template>
  <div class="signin container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Login</h1>
      <form v-on:submit="signin">
          <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" placeholder="Email" v-model="signin.email">
          </div>
          <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Password" v-model="signin.password">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
  </div>
</template>

<script>
import Alert from './Alert'
import axios from 'axios'

// console.log();
export default {
  name: 'Signin',
  data () {
    return {
      login:{},
      alert:''
    }
  },
  methods: {
        signin(e){
            if(!this.signin.email || !this.signin.password){
                alert('Please fill in all required fields');
            } else {
                let newLogin = {
                  email: this.signin.email,
                  password: this.signin.password
                }
                axios.post('http://localhost/slimapi/users/login', newLogin)
                    .then(response =>  {
                        alert(`Account Logged in ${this.signin.email}`);
                        this.$router.go({ path: this.$router.path });   
                        // console.log(response.data.token);
                        const token = response.data.token
                        localStorage.setItem('user-token', token)
                    },
                    err => {
                        alert(err.message);
                    });
                e.preventDefault();
          }
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