import React, { useContext } from "react";
import AppContext from "../contexts/AppContext";
import ApplicationLayout from "../layouts/ApplicationLayout";
import Card from "../components/layout/cards/Card";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";

const TeamStatus = () => {
    const { translations } = useContext(AppContext)

    return (<ApplicationLayout title={translations.title}>
        <main className={"team-status"}>
            <div className={"container"}>
                <Card>
                    <CardHeading>
                        <h1>{translations.team_status_link}</h1>
                    </CardHeading>
                    <CardSection>
                        {/* TODO: build out team status content */}
                    </CardSection>
                </Card>
            </div>
        </main>
    </ApplicationLayout>)
}

export default TeamStatus