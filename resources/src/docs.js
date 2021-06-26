
import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';
import './custom.css'

const spec = require('../../openApi.json');

const ui = SwaggerUI({
  spec,
  dom_id: '#swagger',
});

export default ui;