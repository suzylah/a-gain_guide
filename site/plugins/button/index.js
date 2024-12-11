panel.plugin("again/button-block", {
    blocks: {
      button: `
        <button type="button" @click="open">
          {{ content.text }}
        </button>
      `
    }
  });