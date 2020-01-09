import AcademyRepository from "./AcademyRepository";
const repositories = {
    academy: AcademyRepository
    // other repositories ...
};

export const RepositoryFactory = {
    get: name => repositories[name]
};
