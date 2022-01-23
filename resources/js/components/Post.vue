<template>
  <div class="container">
    <div class="row">
      <div class="card mb-12">
        <a href="#!"
          ><img
            class="card-img-top"
            src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg"
            alt="..."
        /></a>
        <div class="card-body">
          <div class="small text-muted">January 1, 2021</div>
          <h2 class="card-title">Featured Post Title</h2>
          <p class="card-text">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis
            aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta
            expedita corporis animi vero voluptate voluptatibus possimus, veniam
            magni quis!
          </p>
          <a class="btn btn-primary" href="#!">Read more →</a>
        </div>
      </div>
    </div>
    <section>
      <h1>Comments:</h1>
      <div class="form-row">
        <div class="col-3">
          <input
            type="text"
            class="form-control"
            placeholder="Username..."
            v-model="username"
          />
        </div>
        <div class="col-9">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              placeholder="Comment..."
              aria-label="Comment..."
              aria-describedby="basic-addon2"
              v-model="comment"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                type="button"
                :disabled="!isValid || inProgress"
                @click="addComment"
              >
                Add Comment<i v-if="inProgress" class="fa fa-spin fa-spinner"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      username: "Yashar",
      comment: "This is test",
      inProgress: false,
    };
  },
  computed: {
    isValid() {
      return this.username.length > 0 && this.comment.length > 0;
    },
  },
  methods: {
    addComment() {
      this.inProgress = true;
      if (this.isValid) {
        axios
          .post("/api/comment/add", {
            username: this.username,
            comment: this.comment,
          })
          .then((res) => {
            if (res.data.error == false) {
              this.inProgress = false;
              this.comment = "";
              this.username = "";
            }
          });
      }
    },
  },
};
</script>