module.exports = {
  content: [
    "./src/**/*.{html,js,php}", // Mantém o caminho existente
    "./node_modules/flowbite/**/*.js" // Adiciona o novo caminho
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')({
      charts: true,
    }),
  ],
};
