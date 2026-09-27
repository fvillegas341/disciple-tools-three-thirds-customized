/**
 * Split an array into chunks of a given size
 * @param arr
 * @param chunkSize
 * @returns {[]}
 */
export const chunkArray = (arr, chunkSize) => {
  const res = [];
  for (let i = 0; i < arr.length; i += chunkSize) {
    const chunk = arr.slice(i, i + chunkSize);
    res.push(chunk);
  }
  return res;
}

/**
 * Because writing {__html: html} is ugly
 * @param html
 * @returns {{__html}}
 */
export const useHtml = ( html ) => {
  return {__html: html}
}

/**
 * Look up the "status of your team" link for a given WP user.
 * Each member gets their own static page, keyed by their WP user ID.
 * Returns null for anyone not yet assigned a page — callers should
 * hide the link entirely in that case, not fall back to a default.
 * @param userId 
 * @returns {string|null} The team status link for the given user ID, or null if not found
 */
export const getTeamStatusLink = ( userId ) => {
  switch ( userId ) {
    case 2: // TEMP — remove before deploying, just for local testing
      return "https://dng.jrm.church/l/p/el-shaddai-members-lesson-status"; 
    case 6: // Glen Noel — El Shaddai
      return "https://dng.jrm.church/l/p/el-shaddai-members-lesson-status";
    case 7: // Francisco "JonJon" — El Roi
      return "https://dng.jrm.church/l/p/el-roi-members-lesson-status";
    case 8: // Heidi Anne — Adonai Tzidkenu
      return "https://dng.jrm.church/l/p/adonai-tzidkenu-members-lesson-status";
    case 9: // Noreen — Immanuel
      return "https://dng.jrm.church/l/p/immanuel-members-lesson-status";
    case 10: // Cristina — The Light of the World
      return "https://dng.jrm.church/l/p/the-light-of-the-world-members-lesson-status";
    case 11: // Mark Ryan — Jehova Jireh
      return "https://dng.jrm.church/l/p/jehova-jireh-members-lesson-status";
    case 12: // Zenaida — Jehova Rohi
      return "https://dng.jrm.church/l/p/jehova-rohi-members-lesson-status";
    case 13: // Conerlyn — The Living Water
      return "https://dng.jrm.church/l/p/the-living-water-members-lesson-status";
    case 14: // Rem David — The Branch and the Vine
      return "https://dng.jrm.church/l/p/the-branch-and-the-vine-members-lesson-status";
    case 15: // Haydee — The Covenant Keepers
      return "https://dng.jrm.church/l/p/the-covenant-keepers-members-lesson-status";
    case 16: // Donna — The Good Shepherd
      return "https://dng.jrm.church/l/p/the-good-shepherd-members-lesson-status";
    case 17: // Irenea — The Rock of Ages
      return "https://dng.jrm.church/l/p/the-rock-of-ages-members-lesson-status";
    case 19: // Mary Faye Gomez — Jehovah Nissi
      return "https://dng.jrm.church/l/p/jehovah-nissi-members-lesson-status";
    case 20: // Matthew "Matt" Gomez — Jehovah Shalom
      return "https://dng.jrm.church/l/p/jehovah-shalom-members-lesson-status";
    default:
      return null;
  }
}
