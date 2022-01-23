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
                :disabled="!isValid"
                @click="addComment"
              >
                Add Comment
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
    };
  },
  computed: {
    isValid() {
      return this.username.length > 0 && this.comment.length > 0;
    },
  },
  methods: {
    addComment() {
        if(this.isValid()){
            alert("ok");
        }
    },
  },
};
</script>