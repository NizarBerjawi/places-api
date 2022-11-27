
import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';
import './docs.css'

const spec = require('../../public/openApi.json');

const ui = SwaggerUI({
  spec,
  dom_id: '#swagger',
});

export default ui;