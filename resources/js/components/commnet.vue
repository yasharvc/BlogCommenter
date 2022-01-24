<template>
  <div class="comments-container">
    <ul id="comments-list" :class="intentclass">
      <li>
        <div class="comment-main-level">
          <!-- Avatar -->
          <div class="comment-avatar"><img :src="usernameAvatar" alt="" /></div>
          <!-- Contenedor del Comentario -->
          <div class="comment-box">
            <comment-head
              :dialogId="node.id"
              :node="node"
              :spacing="spacing"
              @newReplyAdded="newReplyAdded"
            />
            <div class="comment-content">
              {{ node.comment }}
            </div>
          </div>
        </div>
        <div>
          <comment
            v-for="child in node.children"
            :key="child.id"
            :node="child"
            :spacing="spacing + 1"
            @newReplyAdded="newReplyAdded"
          />
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import commentHead from "./commentBoxHead.vue";
export default {
  name: "comment",
  components: {
    commentHead,
  },
  props: {
    node: {
      type: Object,
      required: true,
    },
    spacing: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      showChildren: false,
    };
  },
  computed: {
    usernameAvatar() {
      return "https://ui-avatars.com/api/?name=" + this.node.username;
    },
    intentclass() {
      if (this.spacing == 0) return "comments-list";
      else if (this.spacing == 1) return "comments-list reply-list";
      else return "comments-list reply-list-2";
    },
    hasChildren() {
      const { children } = this.node;
      return children && children.length > 0;
    },
    toggleChildrenIcon() {
      return this.showChildren ? "fas fa-angle-down" : "fas fa-angle-right";
    },
  },
  methods: {
    toggleChildren() {
      this.showChildren = !this.showChildren;
    },
    newReplyAdded(id, comment) {
      this.$emit("newReplyAdded", id, comment);
    },
  },
};
</script>
<style scoped>
/**
 * Oscuro: #283035
 * Azul: #03658c
 * Detalle: #c7cacb
 * Fondo: #dee1e3
 ----------------------------------*/
* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

a {
  color: #03658c;
  text-decoration: none;
}

ul {
  list-style-type: none;
}

body {
  font-family: "Roboto", Arial, Helvetica, Sans-serif, Verdana;
  background: #dee1e3;
}

/** ====================
 * Lista de Comentarios
 =======================*/
.comments-container {
  margin: 60px auto 15px;
  width: 768px;
}

.comments-container h1 {
  font-size: 36px;
  color: #283035;
  font-weight: 400;
}

.comments-container h1 a {
  font-size: 18px;
  font-weight: 700;
}

.comments-list {
  margin-top: 30px;
  position: relative;
}
</style>
<style>
/**
 * Lineas / Detalles
 -----------------------*/
.comments-list:before {
  content: "";
  width: 2px;
  height: 100%;
  background: #c7cacb;
  position: absolute;
  left: 32px;
  top: 0;
}

.comments-list:after {
  content: "";
  position: absolute;
  background: #c7cacb;
  bottom: 0;
  left: 27px;
  width: 7px;
  height: 7px;
  border: 3px solid #dee1e3;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
}

.reply-list:before,
.reply-list:after {
  display: none;
}
.reply-list li:before {
  content: "";
  width: 60px;
  height: 2px;
  background: #c7cacb;
  position: absolute;
  top: 25px;
  left: -55px;
}
.reply-list-2:before,
.reply-list-2:after {
  display: none;
}
.reply-list-2 li:before {
  content: "";
  width: 142px;
  height: 2px;
  background: #c7cacb;
  position: absolute;
  top: 25px;
  left: -142px;
}

.comments-list li {
  margin-bottom: 15px;
  display: block;
  position: relative;
}

.comments-list li:after {
  content: "";
  display: block;
  clear: both;
  height: 0;
  width: 0;
}

.reply-list,
.reply-list-2 {
  padding-left: 88px;
  clear: both;
  margin-top: 15px;
}
/**
 * Avatar
 ---------------------------*/
.comments-list .comment-avatar {
  width: 65px;
  height: 65px;
  position: relative;
  z-index: 99;
  float: left;
  border: 3px solid #fff;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

.comments-list .comment-avatar img {
  width: 100%;
  height: 100%;
}

.reply-list .comment-avatar {
  width: 50px;
  height: 50px;
}

.reply-list-2 .comment-avatar {
  width: 50px;
  height: 50px;
}

.comment-main-level:after {
  content: "";
  width: 0;
  height: 0;
  display: block;
  clear: both;
}
/**
 * Caja del Comentario
 ---------------------------*/
.comments-list .comment-box {
  width: 680px;
  float: right;
  position: relative;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
}

.comments-list .comment-box:before,
.comments-list .comment-box:after {
  content: "";
  height: 0;
  width: 0;
  position: absolute;
  display: block;
  border-width: 10px 12px 10px 0;
  border-style: solid;
  border-color: transparent #fcfcfc;
  top: 8px;
  left: -11px;
}

.comments-list .comment-box:before {
  border-width: 11px 13px 11px 0;
  border-color: transparent rgba(0, 0, 0, 0.05);
  left: -12px;
}

.reply-list .comment-box {
  width: 610px;
}
.reply-list-2 .comment-box {
  width: 610px;
}

.comment-box .comment-name {
  color: #283035;
  font-size: 14px;
  font-weight: 700;
  float: left;
  margin-right: 10px;
}

.comment-box .comment-name a {
  color: #283035;
}

.comment-box .comment-head span {
  float: left;
  color: #999;
  font-size: 13px;
  position: relative;
  top: 1px;
}

.comment-box .comment-content {
  background: #fff;
  padding: 12px;
  font-size: 15px;
  color: #595959;
  -webkit-border-radius: 0 0 4px 4px;
  -moz-border-radius: 0 0 4px 4px;
  border-radius: 0 0 4px 4px;
}

.comment-box .comment-name.by-author,
.comment-box .comment-name.by-author a {
  color: #03658c;
}
.comment-box .comment-name.by-author:after {
  content: "autor";
  background: #03658c;
  color: #fff;
  font-size: 12px;
  padding: 3px 5px;
  font-weight: 700;
  margin-left: 10px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
@media only screen and (max-width: 766px) {
  .comments-container {
    width: 480px;
  }

  .comments-list .comment-box {
    width: 390px;
  }

  .reply-list .comment-box {
    width: 320px;
  }
  .reply-list-2 .comment-box {
    width: 320px;
  }
}
</style>>

</style>