import dayjs from "dayjs";

require("dayjs/locale/ro");

const utc = require("dayjs/plugin/utc");
const timezone = require("dayjs/plugin/timezone");

dayjs.extend(utc);
dayjs.extend(timezone);

dayjs.tz.setDefault("Europe/Bucharest");

dayjs.locale("ro");
