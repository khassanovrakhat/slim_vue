<template>
  <div class="CV container">
    <h1 class="page-header">CV</h1>

  </div>
</template>

<script>
import Alert from './Alert'
import axios from 'axios'
// console.log(localStorage.getItem('user-token'));

export default {
  name: 'getCV',
  data () {
    return {
      token:{},
      alert:''
    }
  },
  methods: {
        CV(e){
            // if(!this.signin.email || !this.signin.password){
            //     alert('Please fill in all required fields');
            // } else {
                // let newToken = {
                //   token: localStorage.getItem('user-token'),
                // }
                axios.post('http://localhost/slimapi/users/getCV', null, {
                  method: 'post',
                  params: {
                        token:this.$route.query.token
                  }
                })
                .then(function (response){
                    // alert(`Account Logged in ${this.signin.email}`);
                    // this.$router.go({ path: this.$router.path });  
                    console.log(response);
                })//,
                   /* err => {
                        alert(localStorage.getItem('user-token'));
                    // }*///);
                    
                // e.preventDefault();
          // }
          
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