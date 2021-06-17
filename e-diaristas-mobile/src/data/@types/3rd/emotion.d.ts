import AppTheme from "ui/themes/app-theme";

type PaperThemeType = typeof AppTheme;

// Forma do ReactNative aceitar as propriedades do nosso tema no CSS e em outros lugares da aplicação
declare module "@emotion/react" {
  export interface Theme extends PaperThemeType {}
}
