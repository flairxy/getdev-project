<template>
  <span :key="messageComponent" class="badge badge-primary badge-pill">{{ totalUnreadMessages }}</span>
</template>
<script>
import { RepositoryFactory as Repo } from "../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  props: ["messageComponent"],
  data() {
    return {
      messages: []
    };
  },
  methods: {
    getMessages() {
      AR.loggedInUser().then(res => {
        let user = res.data.id;
        AR.tutorMessages(user).then(response => {
          this.messages = response.data;
        });
      });
    }
  },
  created() {
    this.getMessages();
  },
  computed: {
    totalUnreadMessages() {
      let messages = [];
      this.messages.filter(message => {
        if (message.read_at == null) {
          messages.push(message);
        }
      });
      return messages.length;
    }
  }
};
</script>
