import Meetings from "../components/meetings/Meetings";
import Card from "../components/layout/cards/Card";
import CardSection from "../components/layout/cards/CardSection";
import ApplicationLayout from "../layouts/ApplicationLayout";
import React, { useContext } from "react";
import AppContext from "../contexts/AppContext";
import { Button, ButtonGroup } from "react-foundation";
import { Link } from "react-router-dom";
import { getTeamStatusLink } from "../src/helpers";

/**
 * The dashboard page
 * @returns {JSX.Element}
 * @constructor
 */
const Dashboard = () => {
    const { user, magicLink, translations } = useContext(AppContext)
    const teamStatusLink = getTeamStatusLink(user.ID)
    const isExternal = teamStatusLink && teamStatusLink.startsWith("http")

    return (<ApplicationLayout title={translations.title}>
        <main className={"dashboard"}>
            <div className={"container"}>
                <ButtonGroup isExpanded className={"margin-bottom-1"}>
                    <Link to={"/meetings/create"} className={"button"}>
                        {translations.create_meeting}
                    </Link>
                </ButtonGroup>
                <Card>
                    <CardSection>
                        <Meetings />
                    </CardSection>
                </Card>
                <div className={"text-center margin-top-1"}>
                    {teamStatusLink && (
                        isExternal ? (
                            <a href={teamStatusLink}>
                                {translations.team_status_link}
                            </a>
                        ) : (
                            <Link to={teamStatusLink}>
                                {translations.team_status_link}
                            </Link>
                        )
                    )}
                </div>
            </div>

        </main>
    </ApplicationLayout>)
}

export default Dashboard
