module.exports = function (api) {
  api.cache(true);
  return {
    presets: ["babel-preset-expo"],
    plugins: [
      [
        "module-resolver",
        {
          alias: {
            data: "./src/data",
            ui: "./src/ui",
            pages: "./src/pages",
            "@assets": "./src/assets",
            "@styles": "./src/styles",
          },
        },
      ],
      ["react-native-paper/babel"],
    ],
  };
};
