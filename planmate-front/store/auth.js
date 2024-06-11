import { defineStore } from 'pinia';

export const useAuthStore = defineStore('userStore', {
  state: () => ({
    name: 'default',
    token: 'default',
    userId: 'default',
    page: 'default',
  }),
  getters: {
    getUserName() {
      console.log('returning name for ' + this.name);
      return this.name;
    },
    getUserToken() {
      console.log('returning name for ' + this.token);
      return this.token;
    },
    getUserUserId() {
      console.log('returning name for ' + this.userId);
      return this.userId;
    },
    getPage(){
      console.log('returning name for ' + this.page);
      return this.page;
    }
  },
  actions: {
    setUserName(name) {
      this.name = name;
      console.log('setting name for ' + this.name);
    },
    setUserToken(token) {
      this.token = token;
      console.log('setting token for ' + this.token);
    },
    setUserUserId(userId) {
      this.userId = userId;
      console.log('setting userId for ' + this.userId);
    },
    setPage(page){
      this.page = page;
      console.log('setting page for ' + this.page);
    }
  },
});
